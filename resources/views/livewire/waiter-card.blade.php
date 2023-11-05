<div wire:poll.30000ms>
    @if (request()->routeIs('waiter.*'))        
    <div>
        <div class="border-b border-gray-200 dark:border-gray-700 mb-4">
            <ul class="space-x-8 flex flex-wrap -mb-px">
                <x-nav-link href="{{ route('waiter.card') }}" class="py-2 px-4" :active="request()->routeIs('waiter.card')">
                    {{ __('Comandas Virtuais') }}
                </x-nav-link>
                <x-nav-link href="{{ route('waiter.cards-physical') }}" class="py-2 px-4" :active="request()->routeIs('waiter.cards-physical')">
                    {{ __('Comandas Físicas') }}
                </x-nav-link>
            </ul>
        </div>
    </div>
    @endif
    
    <div class="my-2 flex justify-end">
        <x-button class="text-green-600 bg-green-600" wire:click="confirmAddCard" wire:loading.attr="disabled">
            {{ __('Abrir Nova Comanda') }}
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
        <div class="grid grid-cols-3 place-items-center gap-2 my-2">
            @foreach (CardStatus::cases() as $enumStatus)
                <div class="flex flex-col relative justify-between p-2 rounded-lg text-center text-xs overflow-hidden whitespace-nowrap {{ $enumStatus->color() }} shadow-lg w-full">
                    {{ $enumStatus->label() }}
                </div>
            @endforeach
        </div>
    <hr>      
    <div class="grid grid-cols-3 gap-4 mt-2 text-white">
        @foreach ($cards as $card)
            <div tabindex="0" wire:keydown.enter="viewCard({{ $card }})" class="focus:ring-4 ring-offset-2 ring-offset-slate-50 relative flex flex-col justify-between p-4 rounded-lg {{ CardStatus::from($card->status)->color() }} shadow-lg w-full cursor-pointer" wire:click="viewCard({{ $card }})">
                <div class="text-center flex-none"><i class="fas fa-address-card"></i> {{ $card->id }} {{ $card->identity ? '(' . $card->identity . ')' : '' }}</div>
                <div class="text-center flex-none"><i class="fas fa-id-badge"></i> {{ $card->cardPhysical ? $card->cardPhysical->id : 'N/D' }}</div>
                <div class="text-center flex-1"><i class="fas fa-chair"></i> {{ $card->table ? $card->table->id . ($card->table->identity ? ' (' . $card->table->identity . ')' : '') : 'N/D' }}</div>
                <div class="text-center flex-1"><i class="fas fa-clock text-sm"></i> {{ $card->getTime() }}</div>
                <div class="text-center flex-none">@money($card->getConsummationTotal())</div>
                <div class="absolute right-0 bottom-0 p-2"><i class="{{ CardStatus::from($card->status)->icon() }}"></i></div>
            </div>
        @endforeach
    </div>

    <x-dialog-modal wire:model.live="confirmingAddCard">
        <x-slot name="title">
            {{ __('Abrir Nova Comanda') }}
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-label for="atcm_card_physical_id" value="{{ __('Comanda Física') }}" />
                <select wire:model="atcm_card_physical_id" id="atcm_card_physical_id" class="mt-1 block w-3/4 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm'">
                    <option value="">Sem Comanda Física</option>
                    @foreach ($cardsPhysical as $cardPhysical)
                        <option value="{{ $cardPhysical->id }}">{{ $cardPhysical->id }}</option>
                    @endforeach
                </select>
            </div>

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
</div>
