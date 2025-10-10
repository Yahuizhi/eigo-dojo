<?php
namespace App\Services;

use App\Models\StoredQuestion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class WeightService
{
    /**
     * ユーザーの回答履歴を考慮したランダムな質問を取得する
     */
    public function getRandomWeightedQuestion()
    {
        $user = Auth::user();
        $question_count = DB::table('stored_questions')->count();
        // 質問数が20件未満の場合は、その数だけ取得するように修正
        $numberOfItemsToSelect = min($question_count, 20);
        // 質問が1件もない場合はnullを返すなどの処理を追加
        if ($numberOfItemsToSelect === 0) {
            return null;
        }
        $random_ids = collect(range(1, $question_count))->random($numberOfItemsToSelect)->toArray();
   

        // ユーザーの過去の回答履歴を取得
        $random_questions = [];
        foreach ($random_ids as $id) {
            $user_priority = $user->triedStoredQuestions()->where('stored_question_id', $id)->first()?->pivot->priority ?? 0;
            $random_questions[$id] = $user_priority;
        }

        // 設定ファイルから優先度ごとの重みを取得
        $weightMap = config('question.weights');

        // 実際の重みを計算
        $questionActualWeights = [];
        foreach ($random_questions as $questionId => $priority) {
            $questionActualWeights[$questionId] = $weightMap[$priority] ?? 1; // 優先度がない場合はデフォルトの1
        }

        // 重みの調整
        $adjustedWeights = $this->adjustWeightsRandom($questionActualWeights);

        // 重み付きランダム選択
        $selectedQuestionId = $this->weightedRandom($adjustedWeights);

        // 選ばれた質問を取得
        return StoredQuestion::find($selectedQuestionId);
    }

    /**
     * 重みを正規化し、調整する
     */
    private function adjustWeightsRandom(array $weights)
    {
        $totalWeight = array_sum($weights);
        $normalizedWeights = array_map(function ($weight) use ($totalWeight) {
            return $weight / $totalWeight;
        }, $weights);

        $adjustedWeights = [];
        $sum = 0;
        foreach ($normalizedWeights as $questionId => $weight) {
            $adjustedWeights[$questionId] = round($weight, 3);
            $sum += $adjustedWeights[$questionId];
        }

        $diff = 1 - $sum;
        if ($diff != 0) {
            $maxWeight = max($normalizedWeights);
            $candidates = array_keys(array_filter($normalizedWeights, function ($w) use ($maxWeight) {
                return $w == $maxWeight;
            }));
            $randomIndex = array_rand($candidates);
            $randomCandidate = $candidates[$randomIndex];
            $adjustedWeights[$randomCandidate] += $diff;
        }
        return $adjustedWeights;
    }

    /**
     * 重み付きランダム選択を行う
     */
    private function weightedRandom(array $weights)
    {
        $rand = mt_rand(1, array_sum($weights) * 1000) / 1000;
        foreach ($weights as $questionId => $weight) {
            $rand -= $weight;
            if ($rand <= 0) {
                return $questionId;
            }
        }
        return array_key_last($weights);
    }
}
