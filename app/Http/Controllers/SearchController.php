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
        
        
        $sort = $request->get('sort', 'updated_at'); 
        $direction = $request->get('direction', 'desc');
        $keyword = $request->input('keyword');

        
        $questionsQuery = StoredQuestion::query();

        if (!empty($keyword)) {
            $questionsQuery->where('Q', 'like', '%' . $keyword . '%');
        }

        
        $questionsQuery->with(['users' => function ($query) use ($user) {
            $query->where('user_id', $user->id)->withPivot('created_at', 'updated_at', 'answer_count', 'priority');
        }]);

        
        if (in_array($sort, ['answer_count', 'priority', 'created_at', 'updated_at'])) {
            
            $questions = $questionsQuery->get()->map(function ($q) use ($user) {
                
                $pivot = $q->users->first(); 
                $q->pivotData = $pivot ? $pivot->pivot : null;
                return $q;
            });

            
            $questions = $questions->sortBy(function ($item) use ($sort) {
                
                $value = optional($item->pivotData)->$sort;

                
                if ($sort === 'priority' && is_null($value)) {
                    return 1;
                }
                
                
                if ($sort === 'answer_count' && is_null($value)) {
                    return 0;
                }
                
                
                if ($value instanceof \Carbon\Carbon) {
                    return $value->timestamp;
                }

                
                return is_numeric($value) ? $value : -1; 
                
            }, SORT_REGULAR, $direction === 'desc');

            
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
            
            $questionsQuery->with(['users' => function ($query) use ($user) {
                $query->where('user_id', $user->id)->withPivot('created_at', 'updated_at', 'answer_count', 'priority');
            }]);
            
            $QuestionDatas = $questionsQuery->orderBy($sort, $direction)->paginate(10)->withQueryString();
            
            
            foreach ($QuestionDatas as $q) {
                $pivot = $q->users->first(); 
                $q->pivotData = $pivot ? $pivot->pivot : null;
            }
        }

        return view('search', compact('QuestionDatas'));
    }
}