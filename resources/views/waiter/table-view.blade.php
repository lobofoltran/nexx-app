<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Área do Garçom') }}
        </h2>
    </x-slot>
    <div class="max-w-2xl mx-auto mt-4">
        @livewire('waiter-table-view')
    </div>
</x-app-layout>
