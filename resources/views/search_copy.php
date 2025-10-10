<x-app-layout>
    

<div class="flex flex-col md:flex-row gap-6">
    <!-- サイドバー -->
    <div class="w-full md:w-1/4">
        <!-- 検索フォーム -->
        <form class="bg-white shadow-md rounded-lg p-4" action="{{ route('products.index') }}" method="GET">
            <h2 class="text-lg font-semibold mb-4">商品検索</h2>
            
            
            <!-- キーワード検索 -->
            <div class="mb-4">
                <label for="keyword" class="block text-sm font-medium">キーワード</label>
                <input type="text" name="keyword" id="keyword" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" placeholder="メーカー・商品名" value="{{ Request::get('keyword') }}">
            </div>
            <!-- 価格帯検索 -->
            <div class="mb-4">
                <label for="min_price" class="block text-sm font-medium">価格帯</label>
                <div class="flex gap-2">
                    <input type="text" name="min_price" id="min_price" class="w-1/2 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" placeholder="最低価格" value="{{ Request::get('min_price') }}">
                    <input type="text" name="max_price" id="max_price" class="w-1/2 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" placeholder="最高価格" value="{{ Request::get('max_price') }}">
                </div>
            </div>
            <!-- 並び順選択 -->
            <div class="mb-4">
                <label for="sort" class="block text-sm font-medium">並び順</label>
                <select name="sort" id="sort" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                    <option value="">登録順</option>
                    <option value="price_asc"{{ Request::get('sort') == 'price_asc' ? ' selected' : ''}}>価格の安い順</option>
                    <option value="price_desc"{{ Request::get('sort') == 'price_desc' ? ' selected' : ''}}>価格の高い順</option>
                </select>
            </div>
            <!-- 検索ボタン -->
            <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-md shadow hover:bg-indigo-700">検索</button>
        </form>
        <!-- ログアウトフォーム -->
        <form onsubmit="return confirm('ログアウトしますか？')" action="{{ route('logout') }}" method="post" class="mt-4">
            @csrf
            <button type="submit" class="w-full bg-gray-800 text-white py-2 rounded-md shadow hover:bg-gray-900">ログアウト</button>
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
                        <th class="border border-gray-300 px-4 py-2">ID</th>
                        <th class="border border-gray-300 px-4 py-2">カテゴリ</th>
                        <th class="border border-gray-300 px-4 py-2">メーカー</th>
                        <th class="border border-gray-300 px-4 py-2">商品名</th>
                        <th class="border border-gray-300 px-4 py-2">価格</th>
                        <th class="border border-gray-300 px-4 py-2">登録日</th>
                    </tr>
                </thead>
                <!-- テーブルボディ -->
                <tbody>
                    @foreach ($products as $product)
                    <tr>
                        <!-- 商品ID -->
                        <td class="border border-gray-300 px-4 py-2"><a href="{{ route('products.edit', $product) }}" class="text-indigo-600 hover:underline">{{ $product->id }}</a></td>
                        <!-- カテゴリ名 -->
                        <td class="border border-gray-300 px-4 py-2">{{ $product->category->name }}</td>
                        <!-- メーカー名 -->
                        <td class="border border-gray-300 px-4 py-2">{{ $product->maker }}</td>
                        <!-- 商品名 -->
                        <td class="border border-gray-300 px-4 py-2">{{ $product->name }}</td>
                        <!-- 価格 -->
                        <td class="border border-gray-300 px-4 py-2 text-right">{{ $product->price }}</td>
                        <!-- 登録日 -->
                        <td class="border border-gray-300 px-4 py-2 text-center">{{ \Carbon\Carbon::parse($product->created_at)->format('Y年m月d日') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- ページネーション -->
        <div class="mt-4">
            {{ $products->appends(Request::all())->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection

</x-app-layout>