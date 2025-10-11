<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\StoredQuestion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // DBファサードを使用
use App\Models\Question;

class UserQuestionDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'test@example.com')->first();

        if (!$user) {
            $this->command->error("Test user not found.");
            return;
        }

        // 1. 設定したい質問のデータ構造を定義
        $seedData = [
            // StoredQuestion ID => [priority, answer_count, user_answer_text]
            1 => [2, 0, null],                          // 優先度高、回答なし
            2 => [2, 0, null],                          // 優先度高、回答なし
            3 => [2, 0, null],                          // 優先度高、回答なし
            4 => [2, 1, 'This is the first answer test.'],
            5 => [1, 1, 'I am submitting the answer to the question.'],
            6 => [0, 1, 'This question has been answered.'],
            
            7 => [0, 3, 'I have answered this repeatedly.'],
        ];
        
        $pivotData = [];

        // 2. 中間テーブルと回答テーブルのデータを準備
        foreach ($seedData as $stored_question_id => $data) {
            $priority = $data[0];
            $answer_count = $data[1];
            $user_answer_text = $data[2] ?? '初期回答';

            // 中間テーブル用のデータを準備
            $pivotData[$stored_question_id] = [
                'priority' => $priority,
                'answer_count' => $answer_count,
                // 今回のエラー解消済みのため、question_idはnullを渡す
                'question_id' => null, 
            ];

            // 💡 ユーザーの回答履歴 (questionsテーブル) にデータを作成
            for ($i = 0; $i < $answer_count; $i++) {
                // 回答回数分だけレコードを作成する
                Question::create([
                    'user_id' => $user->id,
                    'stored_question_id' => $stored_question_id,
                    'user_answer' => $user_answer_text,
                    // tried_stored_question_id は、中間テーブルの ID か、stored_question_id と同じ値が入る前提
                    // 現状のテーブル構造から stored_question_id の値を仮置き
                    'tried_stored_question_id' => $stored_question_id, 
                ]);
            }
        }
        
        // 3. 中間テーブル ('user_tried_stored_questions') に投入
        $user->triedStoredQuestions()->sync($pivotData);

        $this->command->info("Test user's priority, answer count, and historical answers seeded successfully.");
    }
}