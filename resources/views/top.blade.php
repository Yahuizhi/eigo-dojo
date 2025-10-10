<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('トップページです') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{Auth::user()->name}}
                    {{ __(" さん、こんにちわ！") }}
                </div>
                <div class="p-6 text-gray-900 dark:text-gray-100 text-2xl">
                    <x-nav-link class="
                    font-bold
                    text-4xl
                    md:text-5xl
                    lg:text-6xl
                    leading-tight"
                    :href="route('questions.index')" :active="request()->routeIs('questions.index')">
                        {{ __('けいこ') }}
                    </x-nav-link>

                    {{'しましょうか！'}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
