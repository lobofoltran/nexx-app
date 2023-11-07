<div wire:poll.5000ms class="min-h-screen bg-gray-100">
    <header class="bg-white-800 shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            Comanda #{{ $card->id }} 
            @if ($card->identity)
                ({{$card->identity}})
            @endif
        </div>
    </header>
    <main>
        <div class="max-w-2xl mx-auto mt-4">
            @if ($card->table)
            <div class="p-2">
                <x-button class="my-2 text-2xl w-full" wire:click="solicitarFechamento">SOLICITAR FECHAMENTO</x-button>
            </div>
            <div class="p-2">
                <x-button class="my-2 text-2xl w-full" wire:click="chamarGarcom">CHAMAR O GARÇOM</x-button>
            </div>
            @endif
            <div class="bg-white p-2 px-4 border rounded">
                <div class="my-2"><b>• Comanda:</b> #{{ $card->id }}</div>
                @if ($card->table)
                <div class="my-2"><b>• Mesa:</b> #{{ $card->table->id }} @if ($card->table->identity)({{$card->table->identity}})@endif</div>
                @endif
                <div class="my-2"><b>• Tempo decorrido:</b> {{ $card->getTime() }}</div>
                <div class="my-2"><b>• Total Consumido: </b> @money($card->getConsummationTotal())</div>
            </div>
            <hr>
            <div class="p-2">
                <x-button class="my-2 text-2xl w-full" wire:click="redirectCatalogue">CARDÁPIO DIGITAL (REALIZE SEU PEDIDO)</x-button>
            </div>
            <hr>
            <div class="mt-2 bg-white p-4 border rounded">
                <div class="text-center text-lg">PEDIDOS REALIZADOS</div>
                <hr>
                @foreach ($card->orders as $order)
                    @foreach ($order->orderItems as $item)
                        <div wire:click="addToCalculator({{ $item }})" class="flex justify-between align-self p-4 border-neutral-200 w-full cursor-pointer border-b text-black mt-2">
                            <div>#{{ $card->id }}</div>
                            <div>{{ $item->product->name }}</div>
                            <div class="{{ OrderItemsStatus::from($item->status)->color() }} p-1 rounded">{{ OrderItemsStatus::from($item->status)->label() }}</div>
                            <div>@money($item->value)</div>
                        </div>
                    @endforeach
                @endforeach
                @foreach ($card->groupments as $groupment)
                    @foreach ($groupment->card->orders as $order)
                        @foreach ($order->orderItems as $item)
                            <div wire:click="addToCalculator({{ $item }})" class="flex justify-between p-4 border-neutral-200 w-full cursor-pointer border-b text-black mt-2">
                                <div>#{{ $groupment->card->id }}</div>
                                <div>{{ $item->product->name }}</div>
                                <div class="{{ OrderItemsStatus::from($item->status)->color() }} p-1 rounded">{{ OrderItemsStatus::from($item->status)->label() }}</div>
                                <div>@money($item->value)</div>
                            </div>
                        @endforeach
                    @endforeach
                @endforeach
            </div>
            <hr>
        </div>
    </main>
</div>