<div class="mt-6 bg-white shadow-sm rounded-lg">
@props(['question_answer', 'user', 'storedQuestions', 'pivot'])

@if (Auth::check() && Auth::user()->email !== 'test@example.com')

<div class="p-4 flex space-x-2">
<div class="flex-1">
  <div class="flex justify-between items-center">
      <div>
          <span class="text-gray-800 font-bold">けいこ済み</span>
          
          @if ($question_answer)
              <small class="ml-2 text-sm text-gray-600">{{ $question_answer->created_at->format('Y年n月j日  a g:i') }}</small>
              @unless ($question_answer->created_at->eq($question_answer->updated_at))
                  <small class="text-sm text-gray-600"> &middot; {{ __('編集済み') }}</small>
              @endunless
          @else
              <small class="ml-2 text-sm text-gray-600">日付は利用できません</small>
          @endif
      </div>
      
      @if ($user->is(auth()->user()))
          <x-dropdown>
              <x-slot name="trigger">
                  <button>
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                          <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                      </svg>
                  </button>
              </x-slot>
              <x-slot name="content">
                  <x-dropdown-link :href="route('questions.edit', $question_answer)">
                      {{ __('編集') }}
                  </x-dropdown-link>
                  <form method="POST" action="{{ route('questions.destroy', $question_answer) }}">
                      @csrf
                      @method('delete')
                      <x-dropdown-link :href="route('questions.destroy', $question_answer)" onclick="event.preventDefault(); this.closest('form').submit();">
                          {{ __('削除') }}
                      </x-dropdown-link>
                      <x-dropdown-link href="{{ route('questions.user_posts') }}">
                        {{ __('けいこ歴へ') }}
                      </x-dropdown-link>
                        </div>
                        </div>
                  </form>
              </x-slot>
          </x-dropdown>
      @endif
  </div>
	<div class="py-3 px-3">

  <p class="text-gray-900 font-semibold">
    【質問】</p>
  <p class="mt-1 text-lg text-gray-900">
    {{ $storedQuestions[$question_answer->tried_stored_question_id-1]->Q ?? '質問内容は利用できません' }}</p>
	
	<p class="mt-3 text-gray-900 font-semibold">
    【{{Auth::user()->name}}さんの回答】</p>
  <p class="mt-1 text-lg text-gray-900">
    {{ $question_answer->user_answer ?? '回答がありません' }}</p>

	<p class="mt-3 text-gray-900 font-semibold">
		【回答例】</p>
  <p class="mt-1 text-lg text-gray-900">
    {{ $storedQuestions[$question_answer->tried_stored_question_id-1]->A ?? '回答内容は利用できません' }}</p>

  <p class="mt-3 text-gray-900 font-semibold">
    ★回答回数<a class="mx-4 text-lg text-gray-900">
    {{ $pivot->answer_count ?? '回答回数は利用できません' }}</a>

  <p class="mt-1 text-gray-900 font-semibold">
    ☆質問出現頻度       
  <select class="priority-select mx-5 text-lg text-gray-900" data-question_id="{{ $question_answer->stored_question_id }}">
      <option value="0" {{ isset($pivot) && $pivot->priority == 0 ? 'selected' : '' }}>ごっちゃんです...</option>
      <option value="1" {{ isset($pivot) && $pivot->priority == 1 ? 'selected' : '' }}>けいこする</option>
      <option value="2" {{ isset($pivot) && $pivot->priority == 2 ? 'selected' : '' }}>もっとけいこ</option>
      <option value="3" {{ isset($pivot) && $pivot->priority == 3 ? 'selected' : '' }}>もっともっとけいこ！</option>
  </select></p>
	</div>  
</div>
@else
<div class="p-4 flex space-x-2">
<div class="flex-1">
  <div class="flex justify-between items-center">
      <div>
          <span class="text-gray-800 font-bold">けいこ済み</span>
          
          @if ($question_answer)
              <small class="ml-2 text-sm text-gray-600">{{ $question_answer->created_at->format('Y年n月j日  a g:i') }}</small>
              @unless ($question_answer->created_at->eq($question_answer->updated_at))
                  <small class="text-sm text-gray-600"> &middot; {{ __('編集済み') }}</small>
              @endunless
          @else
              <small class="ml-2 text-sm text-gray-600">日付は利用できません</small>
          @endif
      </div>
      
      @if ($user->is(auth()->user()))
          <x-dropdown>
              <x-slot name="trigger">
                  <button>
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                          <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                      </svg>
                  </button>
              </x-slot>
              <x-slot name="content">                                       
                      <x-dropdown-link href="{{ route('questions.user_posts') }}">
                        {{ __('けいこ歴へ') }}
                      </x-dropdown-link>
                        </div>
                        </div>
                  </form>
              </x-slot>
          </x-dropdown>
      @endif
  </div>
	<div class="py-3 px-3">

  <p class="text-gray-900 font-semibold">
    【質問】</p>
  <p class="mt-1 text-lg text-gray-900">
    {{ $storedQuestions[$question_answer->tried_stored_question_id-1]->Q ?? '質問内容は利用できません' }}</p>
	
	<p class="mt-3 text-gray-900 font-semibold">
    【{{Auth::user()->name}}さんの回答】</p>
  <p class="mt-1 text-lg text-gray-900">
    {{ $question_answer->user_answer ?? '回答がありません' }}</p>

	<p class="mt-3 text-gray-900 font-semibold">
		【回答例】</p>
  <p class="mt-1 text-lg text-gray-900">
    {{ $storedQuestions[$question_answer->tried_stored_question_id-1]->A ?? '回答内容は利用できません' }}</p>

  <p class="mt-3 text-gray-900 font-semibold">
    ★回答回数<a class="mx-4 text-lg text-gray-900">
    {{ $pivot->answer_count ?? '回答回数は利用できません' }}</a>

  <p class="mt-1 text-gray-900 font-semibold">
    ☆質問出現頻度       
  <select class="priority-select mx-5 text-lg text-gray-900" data-question_id="{{ $question_answer->stored_question_id }}">
      <option value="0" {{ isset($pivot) && $pivot->priority == 0 ? 'selected' : '' }}>ごっちゃんです...</option>
      <option value="1" {{ isset($pivot) && $pivot->priority == 1 ? 'selected' : '' }}>けいこする</option>
      <option value="2" {{ isset($pivot) && $pivot->priority == 2 ? 'selected' : '' }}>もっとけいこ</option>
      <option value="3" {{ isset($pivot) && $pivot->priority == 3 ? 'selected' : '' }}>もっともっとけいこ！</option>
  </select></p>
	</div>  
</div>
@endif