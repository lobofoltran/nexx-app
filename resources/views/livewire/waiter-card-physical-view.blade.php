<div>
    <div class="px-2">
        <x-button class="mb-2" wire:click="returnPage" wire:loading.attr="disabled">
            {{ __('Voltar') }}
        </x-button>
    </div>

    @if ($cardPhysical)
    <hr>
        <div class="p-2 grid grid-cols-3 gap-1 my-2 text-white">
            @if ($cardPhysical->status === CardPhysicalStatus::Available->value)
                <x-button class="text-green-600 bg-green-600" wire:click="confirmOpenCard" wire:loading.attr="disabled">
                    {{ __('Abrir Comanda') }}
                </x-button>
            @endif
        </div>
        <div class="bg-white dark:bg-gray-800 pt-4 px-4 border rounded">
            <div class="text-center text-lg">Comanda Física</div>
            <hr>
            <div class="my-4 visible-print text-center">
                {!! QrCode::generate($cardPhysical->routeCostumer()) !!}
            </div>
            <div class="my-4"><b>• Comanda Física:</b> {{ $cardPhysical->id }}</div>
        </div>

        <div class="mt-3 bg-white dark:bg-gray-800 pt-4 px-4 border rounded">
            <div class="text-center text-lg">Comanda Virtual</div>
            <hr>
            @foreach ($cardPhysical->cards->where('status', CardStatus::Active->value) as $card)
                <div class="my-4"><b>• Comanda:</b> {{ $card->id }}</div>
                <div class="my-2 flex justify-between"><div><b>• Identificação:</b> {{ $card->identity }}</div></div>
                <div class="my-2 flex justify-between"><div><b>• Mesa:</b> {{ $card->table ? $card->table->id . ($card->table->identity ? ' (' . $card->table->identity. ')' : '') : '' }} </div></div>
                <div class="my-4"><b>• Tempo decorrido:</b> {{ $card->getTime() }}</div>
                <div class="my-4"><b>• Subtotal: </b> @money($card->getConsummation())</div>
                <div class="my-4"><b>• Pago: </b> @money($card->getPaid())</div>
                <div class="my-4"><b>• Troco: </b> @money($card->getTransshipment())</div>
                <div class="my-4"><x-button class="w-full" wire:click="viewCard({{ $card }})">Visualizar Comanda</x-button></div>
            @endforeach
        </div>

    @else
        <x-error-message :title="__('Não foi possível completar sua requisição')" :text="__('Comanda Física não existe!')"></x-error-message>
    @endif
</div>
