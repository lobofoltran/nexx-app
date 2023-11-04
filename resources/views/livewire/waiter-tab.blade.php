<div>
    <div class="border-b border-gray-200 dark:border-gray-700 mb-4">
        <ul class="space-x-8 flex flex-wrap -mb-px">
            <x-nav-link href="{{ route('waiter.card') }}" class="py-2 px-4" :active="request()->routeIs('waiter.card')">
                {{ __('Comandas') }}
            </x-nav-link>
            <x-nav-link href="{{ route('waiter.cards-physical') }}" class="py-2 px-4" :active="request()->routeIs('waiter.cards-physical')">
                {{ __('Comandas Físicas') }}
            </x-nav-link>
            <x-nav-link href="{{ route('waiter.table') }}" class="py-2 px-4" :active="request()->routeIs('waiter.table')">
                {{ __('Mesas') }}
            </x-nav-link>
            <x-nav-link href="{{ route('waiter.order') }}" class="py-2 px-4" :active="request()->routeIs('waiter.order')">
                {{ __('Pedidos') }}
            </x-nav-link>
        </ul>
    </div>
</div>
