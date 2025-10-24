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

    
    $question_answer = Question::where('user_id', $user->id)->latest()->first(); 

    if ($user && $question_answer && $question_answer->stored_question_id !== null) {
        $pivot = $user->triedStoredQuestions()
        ->where('stored_question_id', $question_answer->stored_question_id)
        ->first()?->pivot;
    } else {
        $pivot = null;
    }

    $storedQuestions = StoredQuestion::all()->keyBy('id');
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
    
    $request->validate([
        'tried_stored_question_id' => 'required|exists:stored_questions,id',
        'stored_question_id' => 'required|exists:stored_questions,id',
        'user_answer' => 'required|string|max:255', 
    ]);
    
    $storedQuestion = StoredQuestion::find($request->stored_question_id);

    
    $question_answer = Question::create([
        'stored_question_id' => $storedQuestion->id,  
        'tried_stored_question_id' => $request->tried_stored_question_id,
        'user_answer' => $request->user_answer,
        'user_id' => auth()->id(), 
    ]);
    

    
    $user = auth()->user();
    $now = now();
    $stored_question_id = $question_answer->stored_question_id;

    $current_answer_count = DB::table('user_tried_stored_questions')
    ->where('user_id', $user->id)
    ->where('stored_question_id', $stored_question_id)
    ->value('answer_count');    
    

if ($current_answer_count > 0) {    
       
    DB::table('user_tried_stored_questions')
        ->where('user_id', $user->id)
        ->where('stored_question_id', $stored_question_id)
        ->increment('answer_count',1,[
            'updated_at' => $now,
    ]);
} else {
    
    DB::table('user_tried_stored_questions')->updateOrInsert(
    [
        'user_id' => $user->id,
        'stored_question_id' => $stored_question_id,
    ],
    [
        'answer_count' => 1,
        'created_at' => $now,
        'updated_at' => $now,       
      
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

        $question->load('user');

        Gate::authorize('delete', $question); 
        
        $question->delete(); 

        return redirect(route('questions.index'));
    }

    public function user_posts(): View
    {
        $user = auth()->user(); 
        $question_answers = Question::where('user_id', $user->id)->latest()->paginate(10); 
        $pivots=$user->triedStoredQuestions()->get();
        
        $storedQuestions = StoredQuestion::all()->keyBy('id');
        
        
        return view('questions.user_posts', compact('question_answers', 'storedQuestions','user','pivots'));
    }
}
