<div wire:poll.5000ms>
    <div class="my-2">
        <div class="relative rounded-lg shadow-sm w-full">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-auto">
              <svg class="absolute text-slate-400 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
              </svg>
            </div>
            <x-input 
                wire:model.live="search" 
                id="table" 
                class="block mt-1 w-full pl-10 py-2 px-3" 
                type="text" 
                name="table" 
                autofocus
                placeholder="{{ __('Pesquisar pedido') }}"/>
        </div>
    </div>
    <hr>
    <div class="grid grid-cols-6 md:gap-1 my-2">
        @foreach (OrderItemsStatus::cases() as $enumStatus)
            <div class="flex flex-col relative justify-between p-1 md:p-2 rounded-lg text-center text-xs overflow-hidden whitespace-nowrap {{ $enumStatus->color() }} shadow-lg w-full">
                {{ $enumStatus->label() }}
            </div>
        @endforeach
    </div>
    <hr>
    <div class="grid grid-cols-3 gap-4 mt-2 text-white">
        @foreach ($orderItems as $orderItem)
            <div tabindex="0" wire:keydown.enter="confirmingMark({{ $orderItem }})" class="focus:ring-4 ring-offset-2 ring-offset-slate-50 flex flex-col relative justify-between p-4 rounded-lg {{ OrderItemsStatus::from($orderItem->status)->color() }} shadow-lg w-full cursor-pointer" wire:click="confirmingMark({{ $orderItem }})">
                <div class="text-center flex-none">#{{ $orderItem->id }}</div>
                <div class="text-center flex-none"><i class="fas fa-address-card"></i> {{ $orderItem->order->card->id }} {{ $orderItem->order->card->identity ? '(' . $orderItem->order->card->identity . ')' : '' }}</div>
                <div class="text-center flex-none"><i class="fas fa-id-badge"></i> {{ $orderItem->order->card->cardPhysical ? $orderItem->order->card->cardPhysical->id : 'N/D' }}</div>
                <div class="text-center flex-none"><i class="fas fa-chair"></i> {{ $orderItem->order->card->table ? $orderItem->order->card->table->id : 'N/D' }}</div>
                <hr class="my-2">
                <div class="text-center flex-none">{{ $orderItem->product->name }}</div>
                <div class="text-center flex-none">{{ $orderItem->observations }}</div>
                <div class="absolute right-0 bottom-0 p-2"><i class="{{ OrderItemsStatus::from($orderItem->status)->icon() }}"></i></div>
            </div>
        @endforeach
    </div>

    <x-dialog-modal wire:model.live="confirmMark">
        <x-slot name="title">
            {{ __('Gerenciar Pedido') }}
        </x-slot>

        <x-slot name="content">
            @if ($confirmItem)
            <div class="text-right">
                <x-button wire:click="setCanceled" class="bg-red-500 text-black">Cancelar Pedido</x-button>
            </div>
            <hr class="my-2">
            <div class="flex flex-col relative justify-between p-4 rounded-lg {{ OrderItemsStatus::from($confirmItem->status)->color() }} shadow-lg w-full">
                <div class="text-center flex-none">#{{ $confirmItem->id }}</div>
                <div class="text-center flex-none"><i class="fas fa-address-card"></i> {{ $confirmItem->order->card->id }} {{ $confirmItem->order->card->identity ? '(' . $confirmItem->order->card->identity . ')' : '' }}</div>
                <div class="text-center flex-none"><i class="fas fa-id-badge"></i> {{ $confirmItem->order->card->cardPhysical ? $confirmItem->order->card->cardPhysical->id : 'N/D' }}</div>
                <div class="text-center flex-none"><i class="fas fa-chair"></i> {{ $confirmItem->order->card->table ? $confirmItem->order->card->table->id : 'N/D' }}</div>
                <hr class="my-2">
                <div class="text-center flex-none">{{ $confirmItem->product->name }}</div>
                <div class="text-center flex-none">{{ $confirmItem->observations }}</div>
                <div class="absolute right-0 bottom-0 p-2"><i class="{{ OrderItemsStatus::from($confirmItem->status)->icon() }}"></i></div>
            </div>
            <hr class="my-2">
            <div class="text-center">
                <x-button wire:click="setDelivered" class="bg-green-500">Marcar como Entregue</x-button>
            </div>
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmMark')" wire:loading.attr="disabled" autofocus>
                {{ __('Cancelar') }}
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>