<div>
    <div class="px-2">
        <x-button class="mb-2" wire:click="returnPage" wire:loading.attr="disabled" autofocus>
            {{ __('Voltar') }}
        </x-button>
    </div>

    @if ($cardPhysical)
    <hr>
        <div class="p-2 grid grid-cols-3 gap-1 my-2 text-white">
            @if ($cardPhysical->status === CardPhysicalStatus::Available->value)
                <x-button class="text-green-600 bg-green-600" wire:click="confirmAddCard" wire:loading.attr="disabled">
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
            <a href="{{ $cardPhysical->routeCostumer() }}" target="blank" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" href="http://localhost:8081/costumer/virtual/9a8ba120-a6d6-4e1b-af33-3d685a7b5b70">
                Link QR Code
            </a>
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
                <div class="my-4"><b>• Subtotal: </b> @money($card->getConsummationTotal())</div>
                <div class="my-4"><b>• Pago: </b> @money($card->getPaidTotal())</div>
                <div class="my-4"><b>• Troco: </b> @money($card->getTransshipmentTotal())</div>
                <div class="my-4"><x-button class="w-full" wire:click="viewCard({{ $card }})">Visualizar Comanda</x-button></div>
            @endforeach
        </div>

        <x-dialog-modal wire:model.live="confirmingAddCard">
            <x-slot name="title">
                {{ __('Abrir Nova Comanda') }}
            </x-slot>
    
            <x-slot name="content">
                <div class="mt-4">
                    <x-label for="atcm_table_id" value="{{ __('Mesa') }}" />
                    <select wire:model="atcm_table_id" id="atcm_table_id" class="mt-1 block w-3/4 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm'">
                        <option value="">Sem mesa</option>
                        @foreach ($tables as $table)
                            <option value="{{ $table->id }}">({{ TableStatus::from($table->status)->label() }}) {{ $table->id }} {{ $table->identity ? '(' . $table->identity. ')' : ''}}</option>
                        @endforeach
                    </select>
                </div>
        
                <div class="mt-4">
                    <x-label for="identity" value="{{ __('Identificação') }}" />
                    <x-input id="identity" type="text" class="mt-1 block w-3/4" wire:model="identity"/>
                </div>
            </x-slot>
    
            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingAddCard')" wire:loading.attr="disabled">
                    {{ __('Cancelar') }}
                </x-secondary-button>
    
                <x-button class="ml-3" wire:click="createCard" wire:loading.attr="disabled" class="ml-2 text-green-600 bg-green-600">
                    {{ __('Criar comanda') }}
                </x-button>
            </x-slot>
        </x-dialog-modal>
    @else
        <x-error-message :title="__('Não foi possível completar sua requisição')" :text="__('Comanda Física não existe!')"></x-error-message>
    @endif
</div>
