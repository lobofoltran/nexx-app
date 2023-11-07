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
                placeholder="{{ __('Pesquisar atração') }}"/>
        </div>
    </div>
    <hr>
    <div class="grid grid-cols-3 md:gap-2 my-2">
        @foreach (ProductEntityStatus::cases() as $enumStatus)
            <div class="flex flex-col relative justify-between p-1 md:p-2 rounded-lg text-center text-xs overflow-hidden whitespace-nowrap {{ $enumStatus->color() }} shadow-lg w-full">
                {{ $enumStatus->label() }}
            </div>
        @endforeach
    </div>
    <hr>
    <div class="grid grid-cols-3 gap-4 mt-2 text-white">
        @foreach ($attractions as $attraction)
            <div tabindex="0" wire:keydown.enter="modalAttraction({{ $attraction }})" wire:click="modalAttraction({{ $attraction }})" class="focus:ring-4 ring-offset-2 ring-offset-slate-50 flex flex-col relative focus-within:shadow-lg justify-between p-4 rounded-lg {{ ProductEntityStatus::from($attraction->status)->color() }} shadow-lg w-full cursor-pointer">
                <div class="absolute right-0 bottom-0 p-2"><i class="{{ ProductEntityStatus::from($attraction->status)->icon() }}"></i></div>
                <div class="text-center flex-none">#{{ $attraction->id }}</div>
                <div class="text-center flex-none">{{ $attraction->name }}</div>
                <div class="text-center flex-none">{{ $attraction->product->name }}</div>
                @if ($attraction->status === ProductEntityStatus::InUse->value)
                    <div class="mb-3 text-center flex-none"><i class="fas fa-clock text-xs"></i> Finaliza às: @hour($attraction->queuesEntities->last()->finish_at)</div>
                @else
                    <div class="mb-3 text-center flex-none">{{ ProductEntityStatus::from($attraction->status)->label() }}</div>
                @endif
            </div>
        @endforeach
    </div>

    <x-dialog-modal wire:model.live="showModalAttraction">
        <x-slot name="title">
            {{ __('Vincular Fila') }}
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-label for="queues" value="{{ __('Fila de Atrações') }}" />
                <select wire:model="selectedQueue" id="queues" class="mt-1 block w-3/4 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm'">
                    <option value="">Selecione um item</option>
                    @if ($selectedAttraction)
                        @foreach ($queues as $queue)
                            @if ($queue->orderItem->product->name === $selectedAttraction->product->name)
                                <option value="{{ $queue->id }}">{{ $queue->id }}</option>
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('showModalAttraction')" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-secondary-button>

            <x-button class="ml-3" wire:click="saveQueue" wire:loading.attr="disabled" class="ml-2 text-green-600 bg-green-600">
                {{ __('Confirmar') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>