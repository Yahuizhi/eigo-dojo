<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\StoredQuestion;
use App\Services\WeightService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;

class WeightServiceTest extends TestCase
{
    use RefreshDatabase;

    private $weightService;

    protected function setUp(): void
    {
        parent::setUp();
        // WeightServiceをインスタンス化
        $this->weightService = new WeightService();
        // テスト用の重み付け設定
        Config::set('question.weights', [
            0 => 10,  // 未回答
            1 => 5,   // 優先度1
            2 => 1,   // 優先度2
            3 => 1,
        ]);
    }

    /** @test */
    public function unansewred_questions_are_selected_more_frequently()
{
    // 1. テストに必要なデータを作成する
    $user = User::factory()->create();

    // 未回答の質問 (priority 0) を10件作成
    StoredQuestion::factory()->count(10)->create();
    
    // 回答済みの質問 (priority 2) を10件作成し、変数に格納する
    $answeredQuestions = StoredQuestion::factory()->count(10)->create();

    
    // StoredQuestionごとに、関連するレコードを作成
    $answeredQuestions->each(function ($storedQuestion) use ($user) {
    // 1. Questionレコードを作成
    $question = \App\Models\Question::factory()->for($user)->create([
        'stored_question_id' => $storedQuestion->id,
        'user_id' => $user->id,
    ]);

    // 2. UserTriedStoredQuestionモデルを直接使って、ピボットレコードを作成
    \App\Models\UserTriedStoredQuestion::create([
        'user_id' => $user->id,
        'stored_question_id' => $storedQuestion->id, // <-- 正しいIDを明示的に渡す
        'question_id' => $question->id,
        'priority' => 2,
    ]);
});


    // 2. 1000回質問をランダムに取得し、選択された質問のIDを記録する
    $counts = [];
    $totalRuns = 1000;
    $this->actingAs($user); // ユーザーをログインさせる
    
    for ($i = 0; $i < $totalRuns; $i++) {
        $question = $this->weightService->getRandomWeightedQuestion();
        $id = $question->id;
        $counts[$id] = ($counts[$id] ?? 0) + 1;
    }

    // 3. 結果を検証する
    // 未回答の質問IDのリストを取得
    $unansweredIds = StoredQuestion::whereDoesntHave('users', function ($query) use ($user) {
        $query->where('user_id', $user->id);
    })->pluck('id')->toArray();

    // 未回答の質問が最も高い頻度で選択されることをアサート
    $unansweredCount = 0;
    foreach ($counts as $id => $count) {
        if (in_array($id, $unansweredIds)) {
            $unansweredCount += $count;
        }
    }
    
    $unansweredRatio = $unansweredCount / $totalRuns;
    // 未回答の質問が全体の半分以上選ばれることを検証
    $this->assertGreaterThan(0.5, $unansweredRatio);
}

    /** @test */
    public function it_handles_fewer_than_20_questions_without_errors()
    {
        // 1. テストに必要なデータを作成する
        $user = User::factory()->create();
        // 5件の質問のみを作成（20件未満）
        StoredQuestion::factory()->count(5)->create();
        $this->actingAs($user);

        $question = null;
    try {
        // コントローラーを介さず、サービスを直接呼び出す
        $question = $this->weightService->getRandomWeightedQuestion();
    } catch (\Exception $e) {
        $this->fail("getRandomWeightedQuestion()が例外をスローしました: " . $e->getMessage());
    }

    $this->assertNotNull($question);
    }
}