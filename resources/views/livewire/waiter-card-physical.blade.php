<div>
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
                placeholder="{{ __('Pesquisar comanda física') }}"/>
        </div>
    </div>
    <hr>
    <div class="grid grid-cols-3 gap-2 my-2">
        @foreach (CardPhysicalStatus::cases() as $enumStatus)
            <div class="flex flex-col relative justify-between p-2 rounded-lg text-center text-sm whitespace-nowrap {{ $enumStatus->color() }} shadow-lg w-full">
                {{ $enumStatus->label() }}
            </div>
        @endforeach
    </div>
    <hr>
    <div class="grid grid-cols-3 gap-4 mt-2 text-white">
        @foreach ($cardPhysicals as $cardPhysical)
            <div class="flex flex-col relative justify-between p-4 rounded-lg {{ CardPhysicalStatus::from($cardPhysical->status)->color() }} shadow-lg w-full cursor-pointer" wire:click="viewCardPhysical({{ $cardPhysical }})">
                <div class="text-center flex-none"><i class="fas fa-id-badge"></i> {{ $cardPhysical->id }}</div>
                <div class="text-center flex-none"><i class="fas fa-address-card"></i> 
                    {{ $cardPhysical->currentCard()->first() ? $cardPhysical->currentCard()->first()->id : '' }} 
                    {{ $cardPhysical->currentCard()->first() ? ($cardPhysical->currentCard()->first()->identity ? '(' . $cardPhysical->currentCard()->first()->identity . ')' : '') : '' }}
                </div>
                <div class="text-center flex-1"><i class="fas fa-chair"></i> 
                    {{ $cardPhysical->currentCard()->first() ? ($cardPhysical->currentCard()->first()->table ? $cardPhysical->currentCard()->first()->table->id . 
                        ($cardPhysical->currentCard()->first()->table->identity ? ' (' . $cardPhysical->currentCard()->first()->table->identity . ')' : '') : 'N/D') : '' }}
                </div>
                <div class="text-center flex-1"><i class="fas fa-clock text-sm"></i> {{ $cardPhysical->currentCard()->first() ? $cardPhysical->currentCard()->first()->getTime() : ''}}</div>
                <div class="text-center flex-none">@money($cardPhysical->currentCard()->first() ? $cardPhysical->currentCard()->first()->getConsummationTotal() : '0')</div>
                <div class="absolute right-0 bottom-0 p-2"><i class="{{ CardPhysicalStatus::from($cardPhysical->status)->icon() }}"></i></div>
            </div>
        @endforeach
    </div>
</div>
