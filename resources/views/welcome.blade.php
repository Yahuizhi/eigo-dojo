<x-wel>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('英語作文道場') }}
        </h2>
    </x-slot>
    

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4 flex-container 
    flex flex-wrap 
    justify-center">             
                <div class="p-6 text-gray-900 dark:text-gray-100 text-2xl mx-auto"> 
                <div class="pw-100">
                <p>             
                ご訪問いただき、ありがとうございます！</p>
                <p>
                このサイトは、TSSTという口答での英語テストを模した英語作文アプリです。</p>
                <p>
                下記からログイン、または登録をお願いします。</p>
                
                <div class="flex-container flex flex-wrap justify-center gap-5 pt-4 w-full md:w-1/2 md:justify-start">
    <form method="GET" action="{{ route('login') }}" class="flex-item flex-grow basis-full md:basis-0">
        <button type="submit" class="
            w-full 
            bg-gray-600 
            text-white 
            py-4           
            rounded-md 
            shadow 
            hover:bg-indigo-700
            font-bold
        ">
            ログイン
        </button>
    </form>
    
    <form method="GET" action="{{ route('register') }}" class="flex-item flex-grow basis-full md:basis-0">
        <button type="submit" class="
            w-full 
            bg-gray-600 
            text-white 
            py-4           
            rounded-md 
            shadow 
            hover:bg-indigo-700
            font-bold
        ">
            登録
        </button>
    </form>
</div>
                </div>
            </div>
        </div>
    </div>

</x-wel>
    