<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\StoredQuestion; 

class StoredQuestionFactory extends Factory
{
    protected $model = StoredQuestion::class;

    public function definition()
    {
        return [            
            'Q' => $this->faker->sentence(), 
            'A' => $this->faker->text(),     
        ];
    }
}