<?php

namespace App\Http\Controllers;

use App\Models\StoredQuestion;
use App\Models\Question;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PriorityController extends Controller
{
    public function priority_update(Request $request): JsonResponse
    {
        $request->validate([
            'question_id' => 'required|exists:stored_questions,id',
            'priority_num' => 'required|integer|min:0|max:3',
        ]);

        $question = Question::findOrFail($request->input('question_id'));

        // ログインユーザー取得
        $user = auth()->user();

        // 該当する質問の pivot テーブルのデータを更新
        $user->triedStoredQuestions()->updateExistingPivot($question->id, [
            'priority' => $request->input('priority_num')
        ]);

        return response()->json([
            'message' => '優先度が更新されました！',
            'question_id' => $question->id,
            'priority_num' => $request->input('priority_num')
        ]);
    }
}

//         $priority_num = $request->input('priority_num');
        
        
//         // DBの更新などを行う（例）
//         // Option::update(['selected_option' => $option]);
// return response()->json(['message' => 'オプションが更新されました']);
    
//     // \Log::info('Request Data:', $request->all());
    
//     $storedQuestion = StoredQuestion::find($request->stored_question_id);

//     // 新しい回答データを作成
//     $question_answer = Question::create([
//         'stored_question_id' => $storedQuestion->id,  
//         'tried_stored_question_id' => $request->tried_stored_question_id,
//         'user_answer' => $request->user_answer,
//         'user_id' => auth()->id(), // 現在ログインしているユーザーの ID を保存
//     ]);
    

//     // ログインユーザーを取得
//     $user = auth()->user();

//     // すでにこの質問に対する回答があれば、answer_count を更新
//     $pivot = $user->triedStoredQuestions()->where('stored_question_id', $question_answer->stored_question_id)->first();

//     return redirect(route('questions.index'));
// }
// }