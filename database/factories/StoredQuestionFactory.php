<?php

// database/factories/StoredQuestionFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\StoredQuestion; // モデルをインポート

class StoredQuestionFactory extends Factory
{
    protected $model = StoredQuestion::class;

    public function definition()
    {
        return [
            // 'Q'と'A'というカラムに、それぞれダミーテキストを生成する
            'Q' => $this->faker->sentence(), // 質問文
            'A' => $this->faker->text(),     // 回答文
        ];
    }
}