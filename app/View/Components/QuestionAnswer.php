<?php

namespace App\View\Components;

use Illuminate\View\Component;

class QuestionAnswer extends Component
{
    public $question_answer;
    public $user;
    public $storedQuestions;

    // コンストラクタで引数を受け取る
    public function __construct($question_answer = null, $user = null, $storedQuestions = null)
    {
        $this->question_answer = $question_answer;
        $this->user = $user;
        $this->storedQuestions = $storedQuestions;
    }

    // ビューをレンダリング
    public function render()
    {
        return view('components.question-answer');
    }
}
