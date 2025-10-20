<?php
namespace App\Services;

use App\Models\StoredQuestion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class WeightService
{
    public function getUserPriority(int $storedQuestionId): int
    {
        $user = Auth::user();

        $pivot = $user->triedStoredQuestions()
        ->where('stored_question_id', $storedQuestionId)
        ->first();

        if ($pivot) {

            return $pivot->pivot->priority ?? 1; 
        }
        return 1;
    }

    public function getRandomWeightedQuestion()
    {
        $user = Auth::user();
        $question_count = DB::table('stored_questions')->count();

        $numberOfItemsToSelect = min($question_count, 20);

        if ($numberOfItemsToSelect === 0) {
            return null;
        }
        $random_ids = collect(range(1, $question_count))->random($numberOfItemsToSelect)->toArray();

        $random_questions = [];
        
        foreach ($random_ids as $id) {
            $user_priority = $user->triedStoredQuestions()->where('stored_question_id', $id)->first()?->pivot->priority ?? 0;
            $random_questions[$id] = $user_priority;
        }

        $weightMap = config('question.weights');

        $questionActualWeights = [];
        foreach ($random_questions as $questionId => $priority) {
            $questionActualWeights[$questionId] = $weightMap[$priority] ?? 1; 
        }

        $adjustedWeights = $this->adjustWeightsRandom($questionActualWeights);

        $selectedQuestionId = $this->weightedRandom($adjustedWeights);

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
