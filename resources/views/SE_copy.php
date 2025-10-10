<x-app-layout>
    

<div class="flex flex-col md:flex-row gap-6">
    <!-- サイドバー -->
    <div class="w-full md:w-1/4">
        <!-- 検索フォーム -->
    <form class="bg-white shadow-md rounded-lg p-4" action="{{ route('search') }}" method="GET">
            <h2 class="text-lg font-semibold mb-4">質問の検索</h2>
    <!-- キーワード検索 -->
    <div class="mb-4">
        <label for="keyword" class="block text-sm font-medium">キーワード</label>
        <input type="text" name="keyword" id="keyword" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" placeholder="メーカー・商品名" value="{{ Request::get('keyword') }}">
    </div>
    <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-md shadow hover:bg-indigo-700">検索</button>
    </form>


        
    </div>
    <!-- メインコンテンツ -->
    <div class="w-full md:w-3/4">
        <!-- テーブルの横スクロール対応 -->
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <!-- 商品リストテーブル -->
            <table class="table-auto w-full border-collapse border border-gray-300">
                <!-- テーブルヘッダー -->
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2">
                            質問
                        </th>
                        <th class="px-4 py-2">
                <a href="{{ route('search', [
                'keyword' => request()->get('keyword'),
                'sort' => 'created_at', 'direction' => request()->get('direction','asc') === 'asc' ? 'desc' : 'asc']) }}">
                    初顔合わせ
                    @if (request()->sort == 'created_at')
                        @if (request()->direction == 'asc')
                            <span>&#8595;</span> <!-- 下矢印 -->
                        @else
                            <span>&#8593;</span> <!-- 上矢印 -->
                        @endif
                    @endif
                </a>
            </th><th class="px-4 py-2">
                <a href="{{ route('search', ['keyword' => request()->get('keyword'),'sort' => 'updated_at', 'direction' => request()->get('direction','asc') === 'asc' ? 'desc' : 'asc']) }}">
                    最近の稽古日
                    @if (request()->sort == 'updated_at')
                        @if (request()->direction == 'asc')
                            <span>&#8595;</span> <!-- 下矢印 -->
                        @else
                            <span>&#8593;</span> <!-- 上矢印 -->
                        @endif
                    @endif
                </a>
            </th><th class="px-4 py-2">
                <a href="{{ route('search', ['keyword' => request()->get('keyword'), 'sort' => 'answer_count', 'direction' => request()->get('direction','asc') === 'asc' ? 'desc' : 'asc']) }}">
                    けいこ回数
                    @if (request()->sort == 'answer_count')
                        @if (request()->direction == 'asc')
                            <span>&#8595;</span> <!-- 下矢印 -->
                        @else
                            <span>&#8593;</span> <!-- 上矢印 -->
                        @endif
                    @endif
                </a>
            </th>
                        <th class="px-4 py-2">
                <a href="{{ route('search', ['keyword' => request()->get('keyword'), 'sort' => 'priority', 'direction' => request()->get('direction','asc') === 'asc' ? 'desc' : 'asc']) }}">
                    優先度
                    @if (request()->sort == 'priority')
                        @if (request()->direction == 'asc')
                            <span>&#8595;</span> <!-- 下矢印 -->
                        @else
                            <span>&#8593;</span> <!-- 上矢印 -->
                        @endif
                    @endif
                </a>
            </th>                 
                    </tr>
                </thead>
                <!-- テーブルボディ -->
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
            <select data-question_id="{{ $QuestionData->id }}">
                <option value="0" {{ ($pivot->priority ?? 0) == 0 ? 'selected' : '' }}>普通</option>
                <option value="1" {{ ($pivot->priority ?? 0) == 1 ? 'selected' : '' }}>戦る</option>
                <option value="2" {{ ($pivot->priority ?? 0) == 2 ? 'selected' : '' }}>もっと戦る！</option>
                <option value="3" {{ ($pivot->priority ?? 0) == 3 ? 'selected' : '' }}>戦らない⋯</option>
            </select>
        </td>
    </tr>
@endforeach



</x-app-layout>