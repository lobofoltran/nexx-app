<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Início') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl dark:bg-gray-800 sm:rounded-lg">
                <div>
                    <div
                        class="p-6 bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700 sm:px-20">
                        <div class="">
                            <img src="{{ asset('/images/logo.png') }}" width="100px"/>
                        </div>
                        <div class="mt-8 text-2xl dark:text-gray-200"> Boas vindas ao Nexx, {{ auth()->user()->name }}!</div>
                        <div class="mt-6 text-gray-500 dark:text-gray-400"> 
                            Esperamos que você tenha a melhor experiência no nosso sistema! Agradecemos a preferência e oportunidade.
                        </div>
                        <div class="mt-8 text-gray-500 dark:text-gray-400 text-sm"> 
                            Atenciosamente,
                        </div>
                        <div class="mt-2 text-gray-500 dark:text-gray-400 text-sm"> 
                            Equipe Nexx.
                        </div>
                    </div>
                    <div class="grid grid-cols-1 bg-gray-200 bg-opacity-25 dark:bg-gray-800 md:grid-cols-2 p-2">
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
