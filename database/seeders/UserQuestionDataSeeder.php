<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\StoredQuestion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Question;

class UserQuestionDataSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'test@example.com')->first();

        if (!$user) {
            $this->command->error("Test user not found.");
            return;
        }
        $seedData = [            
            1 => [2, 0, null],             
            2 => [2, 0, null],            
            3 => [2, 0, null],                          
            4 => [2, 1, 'This is the first answer test.'],
            5 => [1, 1, 'I am submitting the answer to the question.'],
            6 => [0, 1, 'This question has been answered.'],
            
            7 => [0, 3, 'I have answered this repeatedly.'],
        ];
        
        $pivotData = [];

        
        foreach ($seedData as $stored_question_id => $data) {
            $priority = $data[0];
            $answer_count = $data[1];
            $user_answer_text = $data[2] ?? '初期回答';

            
            $pivotData[$stored_question_id] = [
                'priority' => $priority,
                'answer_count' => $answer_count,
            ];

            
            for ($i = 0; $i < $answer_count; $i++) {               
                Question::create([
                    'user_id' => $user->id,
                    'stored_question_id' => $stored_question_id,
                    'user_answer' => $user_answer_text,                
                    'tried_stored_question_id' => $stored_question_id, 
                ]);
            }
        }

        $user->triedStoredQuestions()->sync($pivotData);

        $this->command->info("Test user's priority, answer count, and historical answers seeded successfully."
        );
    }
}