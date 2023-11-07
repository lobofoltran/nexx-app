<div wire:poll.5000ms class="min-h-screen bg-gray-100">
    <header class="bg-white-800 shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            Mesa #{{ $table->id }} 
            @if ($table->identity)
                ({{$table->identity}})
            @endif
        </div>
    </header>
    <main>
        <div class="max-w-2xl mx-auto mt-4">
            <div class="p-2">
                <x-button class="my-2 text-2xl w-full" wire:click="solicitarFechamento">SOLICITAR FECHAMENTO</x-button>
            </div>
            <div class="p-2">
                <x-button class="my-2 text-2xl w-full" wire:click="chamarGarcom">CHAMAR O GARÇOM</x-button>
            </div>
            <div class="bg-white p-2 px-4 border rounded">
                <div class="my-2"><b>• Mesa:</b> #{{ $table->id }} @if ($table->identity)({{$table->identity}})@endif</div>
                <div class="my-2"><b>• Tempo decorrido:</b> {{ $table->getTime() }}</div>
                <div class="my-2"><b>• Total Consumido: </b> @money($table->getConsummationTotal())</div>
            </div>
            <hr>
            <div class="p-2">
                <x-button class="my-2 text-2xl w-full" wire:click="redirectCatalogue">CARDÁPIO DIGITAL</x-button>
            </div>
            <hr>
            <div class="mt-2 bg-white p-4 border rounded">
                <div class="text-center text-lg">PEDIDOS REALIZADOS</div>
                <hr>
                @foreach ($table->cards as $card)
                    @foreach ($card->orders as $order)
                        @foreach ($order->orderItems as $item)
                            <div class="flex justify-between align-self p-4 border-neutral-200 w-full border-b text-black mt-2">
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
                                <div class="flex justify-between p-4 border-neutral-200 w-full border-b text-black mt-2">
                                    <div>#{{ $groupment->card->id }}</div>
                                    <div>{{ $item->product->name }}</div>
                                    <div class="{{ OrderItemsStatus::from($item->status)->color() }} p-1 rounded">{{ OrderItemsStatus::from($item->status)->label() }}</div>
                                    <div>@money($item->value)</div>
                                </div>
                            @endforeach
                        @endforeach
                    @endforeach
                @endforeach
            </div>
            <hr>
        </div>
    </main>
</div>