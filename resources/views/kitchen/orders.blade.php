<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Área da Cozinha') }}
        </h2>
    </x-slot>
    <div class="max-w-2xl mx-auto mt-4">
        @livewire('kitchen-tab')
    </div>
</x-app-layout>
