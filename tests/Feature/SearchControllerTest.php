<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

// StoredQuestion モデルと User モデルをインポートするのを忘れずに
use App\Models\StoredQuestion;
use App\Models\User;

class SearchControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_access_the_search_page()
    {
        // 1. 未認証の状態でGETリクエストを送信する
        $response = $this->get(route('search'));

        // 2. レスポンスがログインページにリダイレクトされることを検証する
        $response->assertRedirect('/login');
    }
    
    // ... 前のテストメソッド ...
    /** @test */
    public function a_logged_in_user_can_search_for_questions_by_keyword()
    {
        // 1. テストに必要なデータを作成する
        //    '検索'というキーワードを含む質問を1つ作成
        $matchingQuestion = StoredQuestion::factory()->create(['Q' => 'これは検索にヒットする質問です。']);
        //    無関係な質問を複数作成
        StoredQuestion::factory()->count(5)->create(['Q' => 'これは無関係な質問です。']);
        
        $user = User::factory()->create();

        // 2. 認証済みの状態で、キーワード付きでGETリクエストを送信する
        $response = $this->actingAs($user)->get(route('search', ['keyword' => '検索']));

        // 3. レスポンスが成功（ステータスコード200）であることを検証する
        $response->assertStatus(200);

        // 4. ビューに渡されたデータが、検索キーワードを含む質問のみであることを検証する
        $response->assertViewHas('QuestionDatas', function ($collection) use ($matchingQuestion) {
            // コレクションには検索に一致した質問のみが含まれているか？
            // count()で件数を確認し、contains()で特定のレコードが存在するか確認
            return $collection->count() === 1 && $collection->contains($matchingQuestion);
        });
    }
}
