<?php

// database/factories/QuestionFactory.php

namespace Database\Factories;

use App\Models\Question; // モデルをインポート
use App\Models\User; // Userモデルも必要なのでインポート
use App\Models\StoredQuestion; // StoredQuestionモデルも必要なのでインポート
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition()
    {
        return [
            // 外部キーは、それぞれのファクトリーを使って関連付けを自動で行う
            'user_id' => User::factory(), 
            'stored_question_id' => StoredQuestion::factory(), 
            'tried_stored_question_id' => StoredQuestion::factory(), 
            'user_answer' => $this->faker->sentence(),
        ];
    }
}