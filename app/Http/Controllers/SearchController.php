<?php

namespace App\Http\Controllers;

use App\Models\StoredQuestion;
use App\Models\Question;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Pagination\LengthAwarePaginator;


class SearchController extends Controller
{
public function __construct()
    {
     
    }
public function index(Request $request)
{
    $user = auth()->user();
    $sort = $request->get('sort', 'updated_at'); // デフォルトはupdated_at
    $direction = $request->get('direction', 'desc');
    $keyword = $request->input('keyword');

    // StoredQuestion取得
    $questionsQuery = StoredQuestion::query();

    if (!empty($keyword)) {
        $questionsQuery->where('Q', 'like', '%' . $keyword . '%');
    }

    // ユーザー情報をwithPivotで取得（全体ではなく、表示ページ分だけに制限）
    $questionsQuery->with(['users' => function ($query) use ($user) {
        $query->where('user_id', $user->id)->withPivot('created_at', 'updated_at', 'answer_count', 'priority');
    }]);

    // ソート（pivotカラムか、StoredQuestionカラムかで分岐）
    if (in_array($sort, ['answer_count', 'priority', 'created_at', 'updated_at'])) {
        // ソートはコレクションで後から行う（Eloquentのままだとソート不可なため）
        $questions = $questionsQuery->get()->map(function ($q) use ($user) {
            $pivot = $q->users->first(); // 1人のユーザーだけ
            $q->pivotData = $pivot ? $pivot->pivot : null;
            return $q;
        });

        //’けいこ前’にも対応 
        $questions = $questions->sortBy(function ($item) use ($sort) {
    $value = optional($item->pivotData)->$sort;

    if ($value instanceof \Carbon\Carbon) {
        return $value->timestamp;
    }

    return is_numeric($value) ? $value : -1;
}, SORT_REGULAR, $direction === 'desc');

        // ページネーションを手動で（コレクションなので）
        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $pagedItems = $questions->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $QuestionDatas = new LengthAwarePaginator(
            $pagedItems,
            $questions->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

    } else {
        // 普通のフィールドでのソート
        $QuestionDatas = $questionsQuery->orderBy($sort, $direction)->paginate(10)->withQueryString();
        // pivot情報もセット
        foreach ($QuestionDatas as $q) {
            $pivot = $q->triedUsers->first();
            $q->pivotData = $pivot ? $pivot->pivot : null;
        }
    }

    return view('search', compact('QuestionDatas'));
}
}
