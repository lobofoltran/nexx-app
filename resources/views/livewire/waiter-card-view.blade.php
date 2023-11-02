<div>
    <div class="px-2">
        <x-button class="mb-2" wire:click="returnPage" wire:loading.attr="disabled">
            {{ __('Voltar') }}
        </x-button>
    </div>

    @if ($card)
    <hr>
    @if ($card->status === CardStatus::Active->value)
        <div class="p-2 grid grid-cols-3 gap-1 my-2 text-white">
            @if ($card->table)
                <x-button class="text-green-600 bg-green-600" wire:click="confirmGroupTables" wire:loading.attr="disabled">
                    {{ __('Agrupar Mesas') }}
                </x-button>
            @endif

            <x-button class="text-green-600 bg-green-600" wire:click="confirmGroupCards" wire:loading.attr="disabled">
                {{ __('Agrupar Comandas') }}
            </x-button>
                
            <x-button wire:click="redirectNewOrder" wire:loading.attr="disabled">
                {{ __('Adicionar Pedido') }}
            </x-button>

            <x-button wire:click="redirectPayment" wire:loading.attr="disabled">
                {{ __('Área de Pagamentos') }}
            </x-button>

            <x-button wire:click="confirmCloseCard" wire:loading.attr="disabled">
                {{ __('Encerrar Comanda') }}
            </x-button>
        </div>
    @else
        <div class="bg-white text-gray-900 py-4 border rounded text-center my-5 text-lg font-medium dark:text-gray-100">Comanda encerrada</div>
    @endif
        <div class="bg-white dark:bg-gray-800 pt-4 px-4 border rounded">
            <div class="text-center text-lg">Comanda</div>
            <hr>
            <div class="my-4"><b>• Comanda:</b> {{ $card->id }}</div>
            <div class="my-2 flex justify-between"><div><b>• Identificação:</b> {{ $card->identity }}</div> @if ($card->status === CardStatus::Active->value) <x-button wire:click="confirmEditIdentity" wire:loading.attr="disabled">{{ __('Editar') }}</x-button>@endif</div>
            <div class="my-2 flex justify-between"><div><b>• Mesa:</b> {{ $card->table ? $card->table->id : '' }}</div> @if ($card->status === CardStatus::Active->value) <x-button wire:click="confirmEditTable" wire:loading.attr="disabled">{{ __('Editar') }}</x-button>@endif</div>
            <div class="my-4"><b>• Tempo decorrido:</b> {{ $card->getTime() }}</div>
            <div class="my-4"><b>• Total Consumido:</b> R$ {{ $card->getConsummation() }},00</div>
            <div class="my-4"><b>• Total Pago:</b> R$ {{ $card->getPaid() }},00</div>
        </div>
        <div class="mt-2 bg-white dark:bg-gray-800 p-4 border rounded">
            <div class="text-center text-lg">Pedidos</div>
            <hr>
            @foreach ($card->orders as $order)
                @foreach ($order->orderItems as $item)
                    <div class="flex justify-between p-4 rounded-lg shadow-lg w-full cursor-pointer text-white mt-2 bg-{{ OrderItemsStatus::from($item->status)->color() }}-600">
                        <div>{{ $item->product->name }}</div>
                        <div>{{ OrderItemsStatus::from($item->status)->label() }}</div>
                        <div>R$ {{ $item->value }},00</div>
                    </div>
                @endforeach
            @endforeach
        </div>
        <div class="mt-2 bg-white dark:bg-gray-800 p-4 border rounded">
            <div class="text-center text-lg">Pagamentos</div>
            <hr>
            <div class="flex justify-between px-4 w-full mt-2">
                <div>Forma Pgto.</div>
                <div>Valor</div>
                <div>Troco</div>
                <div>Status</div>
            </div>
            @foreach ($card->payments as $payment)
                <div class="flex justify-between p-4 rounded-lg shadow-lg w-full cursor-pointer text-white mt-2 bg-{{ PaymentStatus::from($payment->status)->color() }}-600">
                    <div>{{ $payment->paymentMethod->name }}</div>
                    <div>R$ {{ $payment->value }},00</div>
                    <div>R$ {{ $payment->transshipment }},00</div>
                    <div>{{ PaymentStatus::from($payment->status)->label() }}</div>
                </div>
            @endforeach
        </div>
    @else
        <x-error-message :title="__('Não foi possível completar sua requisição')" :text="__('Comanda não existe!')"></x-error-message>
    @endif
</div>
