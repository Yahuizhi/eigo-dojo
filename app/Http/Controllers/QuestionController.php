<?php

namespace App\Http\Controllers;

use App\Models\StoredQuestion;
use App\Models\Question;
use App\Services\WeightService;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;



class QuestionController extends Controller
{
    protected $weightService;
    public function __construct(WeightService $weightService){
        $this->weightService = $weightService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): View
{
    $user = auth()->user();

    // 1. 最新の回答と質問IDを取得
    $question_answer = Question::where('user_id', $user->id)->latest()->first(); 

    if ($user && $question_answer && $question_answer->stored_question_id !== null) {
        $pivot = $user->triedStoredQuestions()
        ->where('stored_question_id', $question_answer->stored_question_id)
        ->first()?->pivot;
    } else {
        $pivot = null;
    }

    $storedQuestions = StoredQuestion::orderBy('created_at', 'asc')->get();
    $random_q = $this->weightService->getRandomWeightedQuestion();
    

    return view('questions.index', compact('question_answer', 'storedQuestions', 'random_q', 'user','pivot' ));


}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
{
    // \Log::info('Request Data:', $request->all());
    $request->validate([
        'tried_stored_question_id' => 'required|exists:stored_questions,id',
        'stored_question_id' => 'required|exists:stored_questions,id',
        'user_answer' => 'required|string|max:255', 
    ]);
    
    $storedQuestion = StoredQuestion::find($request->stored_question_id);

    // 新しい回答データを作成
    $question_answer = Question::create([
        'stored_question_id' => $storedQuestion->id,  
        'tried_stored_question_id' => $request->tried_stored_question_id,
        'user_answer' => $request->user_answer,
        'user_id' => auth()->id(), // 現在ログインしているユーザーの ID を保存
    ]);
    

    // ログインユーザーを取得
    $user = auth()->user();

    // すでにこの質問に対する回答があれば、answer_count を更新
    $pivot = $user->triedStoredQuestions()->where('stored_question_id', $question_answer->stored_question_id)->first();
    

if ($pivot) {
    // すでに回答済みなら `answer_count` を増やす
    // answer_count が NULL の場合、0 として初期化
    $newAnswerCount = $pivot->pivot->answer_count ?? 0;
    
    // `updateExistingPivot` では、ユーザーIDと質問IDを正しく渡す
    $user->triedStoredQuestions()->updateExistingPivot($question_answer->stored_question_id, [
        'answer_count' => $newAnswerCount + 1,  // answer_count に1を加算
        'updated_at' => now(),
    ]);
} else {
    // 初めて回答する場合は、新規登録
    $user->triedStoredQuestions()->attach($question_answer->stored_question_id, [
        'answer_count' => 1,  // 初回回答時は 1
        'priority' => 1,
        'question_id' => $question_answer->id,
    ]);
}

    return redirect(route('questions.index'));
}



    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question): View
    {
        Gate::authorize('update', $question);

        return view('questions.edit', [
            'question' => $question,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        Gate::authorize('update', $question);
        $validated = $request->validate([
            'user_answer' => 'required|string|max:500',
        ]);

        $question->update($validated);

        return redirect(route('questions.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
        public function destroy(Question $question): RedirectResponse
    {
        // 💡 修正: リレーションを 'users' から 'user' に変更
        // ただし、Gate::authorize('delete', $question); は $question モデルを渡すので、
        // Eager Loadingは必須ではありません。今回は $question を直接使います。
        
        // 削除前のポリシーチェックで、Questionモデル自体に紐づくuserをロードさせる
        // 確実にロードさせるなら、以下のように書くか、
        // $question->load('user'); 
        
        // もしくは、リレーションの呼び出しを修正します。
        // $question = Question::with('user')->find($question->id); // id指定は不要

        // Route Model Binding (Question $question) を利用し、リレーションを単数形 'user' でロード

        $question->load('user');

        Gate::authorize('delete', $question); // ポリシーチェック
        
        $question->delete(); // 削除処理

        return redirect(route('questions.index'));
    }

    public function user_posts(): View
    {
        $user = auth()->user(); // ログインユーザー取得
        $question_answers = Question::where('user_id', $user->id)->latest()->paginate(10); // ログインユーザーの投稿のみ取得   
        $pivots=$user->triedStoredQuestions()->get();
        
        $storedQuestions = StoredQuestion::orderBy('created_at', 'asc')->get();
        
        // $question_answer = Question::where('user_id', $user->id)->latest()->first(); // ログインユーザーの最新投稿を取得
        return view('questions.user_posts', compact('question_answers', 'storedQuestions','user','pivots'));
    }
}
