<!-- resources/views/questions/index.blade.php -->
<x-app-layout>
    <div class="mt-6 bg-white shadow-sm rounded-lg divide-y max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <div >
            <div>
                <div class="flex justify-between items-center font-bold">
                    <!-- ランダムな質問を表示 -->
                    <p>{{ $random_q->Q }}</p> 
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('questions.store') }}">
            @csrf
            <input type="hidden" name="tried_stored_question_id" value="{{ $random_q->id }}">
            <input type="hidden" name="stored_question_id" value="{{ $random_q->id }}">
            <textarea
                name="user_answer"
                placeholder="{{ __('Please your answer!') }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm h-32 break-words"
            >{{ old('user_answer') }}</textarea>
            <x-input-error :messages="$errors->get('message')" class="mt-2" />
            <x-primary-button class="mt-4">{{ __('Answer') }}</x-primary-button>
        </form>
                
        <!-- 回答があれば表示 -->
        @if($question_answer)

        <x-question-answer 
        :question_answer="$question_answer" 
        :user="$user" 
        :storedQuestions="$storedQuestions"
        :pivot="$pivot" />
        @endif
    </div>
</x-app-layout>
