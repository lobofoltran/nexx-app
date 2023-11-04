<div>
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
                placeholder="{{ __('Pesquisar mesa') }}"/>
        </div>
    </div>
    <hr>
    <div class="grid grid-cols-6 gap-1 my-2">
        @foreach (TableStatus::cases() as $enumStatus)
            <div class="flex flex-col relative justify-between p-2 rounded-lg text-center text-sm whitespace-nowrap {{ $enumStatus->color() }} shadow-lg w-full">
                {{ $enumStatus->label() }}
            </div>
        @endforeach
    </div>
    <hr>
    <div class="grid grid-cols-3 gap-4 mt-2 text-white">
        @foreach ($tables as $table)
            <div class="flex flex-col relative justify-between p-4 rounded-lg {{ TableStatus::from($table->status)->color() }} shadow-lg w-full cursor-pointer" wire:click="viewTable({{ $table }})">
                <div class="text-center flex-none">{{ $table->id }} {{ $table->identity ? '(' . $table->identity . ')' : '' }}</div>
                <div class="text-center flex-none"><i class="fas fa-users text-sm"></i> {{ $table->cards_quantity }}</div>
                <div class="text-center flex-none"><i class="fas fa-clock text-sm"></i> {{ $table->getTime() }}</div>
                <div class="text-center flex-none">@money($table->getConsummation())</div>
                @if ($table->status === TableStatus::Grouped->value)
                    <div class="absolute right-0 bottom-0 p-2"><i class="fas fa-paperclip"></i></div>
                @endif
            </div>
        @endforeach
    </div>
</div>
