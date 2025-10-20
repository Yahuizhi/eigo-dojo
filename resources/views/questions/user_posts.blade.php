<x-app-layout>
    <div class="mt-6 bg-white shadow-sm rounded-lg divide-y max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">        
        @foreach ($question_answers->zip($pivots) as $pair)
            @php                
                $question_answer = $pair[0];
                $pivot = $pair[1];
                
                if (is_null($question_answer)) {
                    continue;
                }

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
