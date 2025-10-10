<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Question;
use App\Models\StoredQuestion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    // tests/Feature/QuestionControllerTest.php

/** @test */
public function a_logged_in_user_can_view_the_questions_index_page()
{
    // 1. テスト用のユーザーを作成し、ログイン状態をシミュレートする
    $user = User::factory()->create();

    // 2. Questionのレコードを事前に作成し、ユーザーと関連付ける
    //    コントローラーのindexメソッドが依存するデータを用意する
    Question::factory()->for($user)->create();

    // 3. WeightService が要求する20件以上の質問データを事前に作成する
    //    30件作成しておけば確実
    StoredQuestion::factory()->count(30)->create();

    // 4. 認証済みユーザーとして'questions.index'にアクセスする
    $response = $this->actingAs($user)->get(route('questions.index'));

    // 5. レスポンスが成功（ステータスコード200）であることを検証する
    $response->assertStatus(200);

    // 6. 正しいビューが表示されていることを検証する
    $response->assertViewIs('questions.index');
}
}