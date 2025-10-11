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
    // ... バリデーション ...
    
    // 💡 デバッグログ 1: 取得したIDとユーザーを確認
    \Log::info('Priority Update Request:', [
        'user_id' => auth()->id(), 
        'question_id' => $request->input('question_id'),
        'priority_num' => $request->input('priority_num')
    ]);

    $storedQuestion = StoredQuestion::findOrFail($request->input('question_id'));
    $user = auth()->user();

    // 💡 デバッグログ 2: リレーションの情報を確認
    // $user->triedStoredQuestions() のリレーションが User モデルで正しく定義されているか
    // 中間テーブルに priority カラムがあるか
    
     
    // 💡 解決コード: 必須カラム question_id と answer_count に値を渡す
    $updated =
    $user->triedStoredQuestions()
    ->updateExistingPivot($storedQuestion->id, [
        'priority' => $request->input('priority_num'),
        // 'question_id' や 'answer_count' を渡す必要はもうありません！
]);
    
    // 💡 デバッグログ 3: 更新が成功したかを確認 (1なら成功)
    \Log::info('Pivot Update Result:', ['updated_rows' => $updated]);

    if ($updated===0) {
        // 既存レコードが存在しない場合は 0 が返る。
        // この時点で新規作成の機能は使わず、エラーを返すか、
        // 🚨 意図的に新規作成を許可するなら、ここで attach() を使う。
        // ただし、今回は「更新」機能と分離するのがベスト。
        return response()->json(['message' => '優先度を更新できませんでした（レコードなし）。', 'updated' => 0], 404);
    }
    
    return response()->json([
        'message' => '優先度が更新されました！',
        'question_id' => $storedQuestion->id,
        'priority_num' => $request->input('priority_num')
    ]);
}
}