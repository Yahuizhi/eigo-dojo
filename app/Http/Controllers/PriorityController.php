<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class PriorityController extends Controller
{
    
    public function priority_update(Request $request): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json(['message' => '認証が必要です。'], 401);
        }
        
        try {
            $validated = $request->validate([
                'question_id' => 'required|integer|exists:stored_questions,id',
                'priority_num' => 'required|integer|in:0,1,2,3', 
            ]);

            $user = auth()->user();
            $storedQuestionId = $validated['question_id'];
            $priority = $validated['priority_num'];
            $userId = $user->id;
            $pivotTable = 'user_tried_stored_questions';
            
            $existing = DB::table($pivotTable)
                ->where('user_id', $userId)
                ->where('stored_question_id', $storedQuestionId)
                ->first();

            if ($existing) {
                $updateData = [
                    'priority' => $priority,                    
                ];

                DB::table($pivotTable)
                    ->where('user_id', $userId)
                    ->where('stored_question_id', $storedQuestionId)
                    ->update($updateData);

            } else {
                DB::table($pivotTable)->insert([
                    'user_id' => $userId, 
                    'stored_question_id' => $storedQuestionId,
                    'priority' => $priority,                    
                ]);
            }

            Log::info("Priority updated successfully (Timestamp preserved).", [
                'user_id' => $userId, 
                'question_id' => $storedQuestionId, 
                'priority' => $priority
            ]);
            
            return response()->json([
                'message' => 'Priority updated successfully',
                'question_id' => $storedQuestionId,
                'priority_num' => $priority
            ], 200);

        } catch (\Throwable $e) {
            
            Log::error("Priority update failed.", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json(['message' => 'Priority update failed due to a server error.'], 500);
        }
    }
}
