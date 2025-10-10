<x-app-layout>
    <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">        
        @foreach ($question_answers->zip($pivots) as $pair)
            @php
                // $pair[0] は $question_answer, $pair[1] は対応する $pivot
                $question_answer = $pair[0];
                $pivot = $pair[1];
                $result = $user->triedStoredQuestions()->where('stored_question_id', $question_answer->stored_question_id)->first();
                $pivot = $result ? $result->pivot : null;
            @endphp
            <x-question-answer 
                :question_answer="$question_answer" 
                :user="$user" 
                :storedQuestions="$storedQuestions"
                :pivot="$pivot" />        
        
        @endforeach
        <div class="mt-4">
            {{ $question_answers->appends(Request::all())->links('pagination::tailwind') }}
        </div>


    </div>
</x-app-layout>
