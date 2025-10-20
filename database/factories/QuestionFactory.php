<?php



namespace Database\Factories;

use App\Models\Question; 
use App\Models\User; 
use App\Models\StoredQuestion; 
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition()
    {
        return [
            
            'user_id' => User::factory(), 
            'stored_question_id' => StoredQuestion::factory(), 
            'tried_stored_question_id' => StoredQuestion::factory(), 
            'user_answer' => $this->faker->sentence(),
        ];
    }
}