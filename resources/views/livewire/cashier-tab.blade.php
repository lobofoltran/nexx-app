<div>
    <div class="border-b border-gray-200 dark:border-gray-700 mb-4">
        <ul class="space-x-8 flex flex-wrap -mb-px">
            <x-nav-link href="{{ route('cashier.cards') }}" class="py-2 px-4" :active="request()->routeIs('cashier.cards')">
                {{ __('Comandas') }}
            </x-nav-link>
            <x-nav-link href="{{ route('cashier.cards-physical') }}" class="py-2 px-4" :active="request()->routeIs('cashier.cards-physical')">
                {{ __('Comandas Físicas') }}
            </x-nav-link>
            <x-nav-link href="{{ route('cashier.table') }}" class="py-2 px-4" :active="request()->routeIs('cashier.table')">
                {{ __('Mesas') }}
            </x-nav-link>
            {{-- <x-nav-link href="{{ route('cashier.orders') }}" class="py-2 px-4" :active="request()->routeIs('cashier.orders')">
                {{ __('Pedidos') }}
            </x-nav-link> --}}
            <x-nav-link href="{{ route('cashier.calls') }}" class="py-2 px-4" :active="request()->routeIs('cashier.calls')">
                {{ __('Chamados') }}
            </x-nav-link>
        </ul>
    </div>
</div>
