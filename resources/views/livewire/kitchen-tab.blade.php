<div>
    <div class="border-b border-gray-200 dark:border-gray-700 mb-4">
        <ul class="space-x-8 flex flex-wrap -mb-px">
            <x-nav-link href="{{ route('kitchen.orders') }}" class="py-2 px-4" :active="request()->routeIs('kitchen.orders')">
                {{ __('Pedidos') }}
            </x-nav-link>
        </ul>
    </div>
</div>
