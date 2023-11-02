<div>
    <div class="my-2 flex justify-end">
        <x-button class="text-green-600 bg-green-600" wire:click="confirmAddCard" wire:loading.attr="disabled">
            {{ __('Adicionar Comanda') }}
        </x-button>
    </div>
    <hr>
    <div class="my-2">
        <div class="relative rounded-lg shadow-sm w-full">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-auto">
              <svg class="absolute text-slate-400 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
              </svg>
            </div>
            <x-input 
                wire:model.live="search" 
                id="card" 
                class="block mt-1 w-full pl-10 py-2 px-3" 
                type="text" 
                name="card" 
                autofocus
                placeholder="{{ __('Pesquisar comanda') }}"/>
        </div>
    </div>
    <hr>
    <div class="grid grid-cols-3 gap-4 mt-2 text-white">
        @foreach ($cards as $card)
            <div class="flex flex-col justify-between p-4 rounded-lg bg-{{ CardStatus::from($card->status)->color() }}-500 shadow-lg h-32 w-full cursor-pointer" wire:click="viewCard({{ $card }})">
                <div class="text-center flex-none">{{ $card->id }} {{ $card->table ? '(' . $card->table->id . ')' : '' }}</div>
                <div class="text-center flex-1">{{ $card->identity ?? '' }}</div>
                <div class="text-center flex-1">{{ $card->getTime() }}</div>
                <div class="text-center flex-none">R$ {{ $card->getConsummation() }},00</div>
            </div>
        @endforeach
    </div>

    <x-dialog-modal wire:model.live="confirmingAddCard">
        <x-slot name="title">
            {{ __('Adicionar Comanda') }}
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-label for="identity" value="{{ __('Identificação') }}" />
                <x-input id="identity" type="text" class="mt-1 block w-3/4" wire:model="identity"/>
            </div>

            <div class="mt-4">
                <x-label for="atcm_table_id" value="{{ __('Mesa') }}" />
                <select wire:model="atcm_table_id" id="atcm_table_id" class="mt-1 block w-3/4 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm'">
                    <option value="">Sem mesa</option>
                    @foreach ($tables as $table)
                        <option value="{{ $table->id }}">{{ $table->id }} {{ $table->identity ? '(' . $table->identity. ')' : ''}}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4">
                <x-label for="atcm_qrcode_id" value="{{ __('QR Code') }}" />
                <select wire:model="atcm_qrcode_id" id="atcm_qrcode_id" class="mt-1 block w-3/4 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm'">
                    <option value="">Sem QR Code</option>
                </select>
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
</div>
