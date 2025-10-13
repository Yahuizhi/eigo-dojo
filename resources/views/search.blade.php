<x-app-layout>
    

<div class="flex flex-col md:flex-row gap-6 px-2 md:px-0">
   
    <div class="w-full md:w-1/4">
        
    <form class="bg-white shadow-md rounded-lg p-4" action="{{ route('search') }}" method="GET">
            <h2 class="text-lg font-semibold mb-4">質問の検索</h2>
   
    <div class="mb-4">
        <label for="keyword" class="block text-sm font-medium">キーワード</label>
        <input type="text" name="keyword" id="keyword" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" placeholder="質問名" value="{{ Request::get('keyword') }}">
    </div>
    <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-md shadow hover:bg-indigo-700">検索</button>
    </form>


        
    </div>
  
    <div class="w-full md:w-3/4">
       
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            
            <table class="table-fixed md:table-auto w-full border-collapse border border-gray-300">
              
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2">
                            質問
                        </th>
                        <th class="px-4 py-2 hover:bg-gray-300 active:bg-gray-500 focus:border-gray-700">
                <a href="{{ route('search', [
                'keyword' => request()->get('keyword'),
                'sort' => 'created_at', 'direction' => request()->get('direction','asc') === 'asc' ? 'desc' : 'asc']) }}">
                    初顔合わせ
                    @if (request()->sort == 'created_at')
                        @if (request()->direction == 'asc')
                            <span>&#8595;</span> 
                        @else
                            <span>&#8593;</span> 
                        @endif
                    @endif
                </a>
            </th><th class="px-4 py-2 hover:bg-gray-300 active:bg-gray-500 focus:border-gray-700">
                <a href="{{ route('search', ['keyword' => request()->get('keyword'),'sort' => 'updated_at', 'direction' => request()->get('direction','asc') === 'asc' ? 'desc' : 'asc']) }}">
                    最新の稽古日
                    @if (request()->sort == 'updated_at')
                        @if (request()->direction == 'asc')
                            <span>&#8595;</span> 
                        @else
                            <span>&#8593;</span> 
                        @endif
                    @endif
                </a>
            </th><th class="px-4 py-2 hover:bg-gray-300 active:bg-gray-500 focus:border-gray-700">
                <a href="{{ route('search', ['keyword' => request()->get('keyword'), 'sort' => 'answer_count', 'direction' => request()->get('direction','asc') === 'asc' ? 'desc' : 'asc']) }}">
                    けいこ回数
                    @if (request()->sort == 'answer_count')
                        @if (request()->direction == 'asc')
                            <span>&#8595;</span> 
                        @else
                            <span>&#8593;</span> 
                        @endif
                    @endif
                </a>
            </th>
                        <th class="px-4 py-2 hover:bg-gray-300 active:bg-gray-500 focus:border-gray-700">
                <a href="{{ route('search', ['keyword' => request()->get('keyword'), 'sort' => 'priority', 'direction' => request()->get('direction','asc') === 'asc' ? 'desc' : 'asc']) }}">
                    質問出現頻度
                    @if (request()->sort == 'priority')
                        @if (request()->direction == 'asc')
                            <span>&#8595;</span> 
                        @else
                            <span>&#8593;</span>            
                        @endif
                    @endif
                </a>
            </th>                 
                    </tr>
                </thead>
                
                <tbody>                    
                    @foreach ($QuestionDatas as $QuestionData)
    @php
        $pivot = $QuestionData->pivotData;        
    @endphp
    <tr>
        <td class="border px-4 py-2">{{ $QuestionData->Q }}</td>
        <td class="border px-4 py-2">
            {{ $pivot && $pivot->created_at ? \Carbon\Carbon::parse($pivot->created_at)->format('Y年m月d日') : 'けいこ前' }}
        </td>
        <td class="border px-4 py-2">
            {{ $pivot && $pivot->updated_at ? \Carbon\Carbon::parse($pivot->updated_at)->format('Y年m月d日') : 'けいこ前' }}
        </td>
        <td class="border px-4 py-2">{{ $pivot->answer_count ?? 0 }}</td>
        <td class="border px-4 py-2">
            <select class="priority-select" data-question_id="{{ $QuestionData->id }}">
                <option value="0" {{ ($pivot->priority ?? 1) == 0 ? 'selected' : '' }}>低い</option>
                <option value="1" {{ ($pivot->priority ?? 1) == 1 ? 'selected' : '' }}>並</option>
                <option value="2" {{ ($pivot->priority ?? 1) == 2 ? 'selected' : '' }}>高い</option>
                <option value="3" {{ ($pivot->priority ?? 1) == 3 ? 'selected' : '' }}>最高！</option>
            </select>
        </td>
    </tr>
@endforeach
</tbody>
            </table>       
        </div>    
    
        
        <div class="mt-4">
            {{ $QuestionDatas->appends(Request::all())->links('pagination::tailwind') }}
        </div>
        

        
    </div>
</div></x-app-layout>