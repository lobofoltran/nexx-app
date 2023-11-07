<div wire:poll.5000ms>
    <div class="my-2">
        <div class="relative rounded-lg shadow-sm w-full">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-auto">
              <svg class="absolute text-slate-400 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
              </svg>
            </div>
            <x-input wire:model.live="search" class="block mt-1 w-full pl-10 py-2 px-3" type="text" autofocus placeholder="{{ __('Pesquisar na fila') }}"/>
        </div>
    </div>
    <hr>
    <div class="grid grid-cols-4 md:gap-2 my-2">
        @foreach (OrderItemQueueStatus::cases() as $enumStatus)
            <div class="flex flex-col relative justify-between p-1 md:p-2 rounded-lg text-center text-xs overflow-hidden whitespace-nowrap {{ $enumStatus->color() }} shadow-lg w-full">
                {{ $enumStatus->label() }}
            </div>
        @endforeach
    </div>
    <hr>
    <div class="grid grid-cols-3 gap-4 mt-2 text-white">
            @foreach ($queues as $queue)
                <div tabindex="0" wire:keydown.enter="modalQueue({{ $queue }})" wire:click="modalQueue({{ $queue }})" class="focus:ring-4 ring-offset-2 ring-offset-slate-50 flex flex-col relative focus-within:shadow-lg justify-between p-4 rounded-lg {{ OrderItemQueueStatus::from($queue->status)->color() }} shadow-lg w-full cursor-pointer">
                    <div class="absolute right-0 bottom-0 p-2"><i class="{{ OrderItemQueueStatus::from($queue->status)->icon() }}"></i></div>
                    <div class="text-center flex-none">#{{ $queue->id }}</div>
                    <div class="text-center flex-none"><i class="fas fa-address-card"></i> {{ $queue->orderItem->order->card->id }} {{ $queue->orderItem->order->card->identity ?  '(' . $queue->orderItem->order->card->identity .')' : '' }}</div>
                    <div class="text-center flex-none">{{ $queue->orderItem->product->name }}</div>
                    <div class="text-center flex-none">@dateHour($queue->created_at)</div>
                    <div class="text-center flex-none"><i class="fas fa-clock text-sm"></i> {{ $queue->orderItem->product->time }}</div>
                </div>
            @endforeach
    </div>

    <x-dialog-modal wire:model.live="showModalQueue">
        <x-slot name="title">
            {{ __('Vincular Atração') }}
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-label for="attractions" value="{{ __('Atrações Disponíveis') }}" />
                <select wire:model="selectedAttraction" id="attractions" class="mt-1 block w-3/4 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm'">
                    <option value="">Selecione um item</option>
                    @if ($selectedQueue)
                        @foreach ($attractions as $attraction)
                            @if ($selectedQueue->orderItem->product->name === $attraction->product->name)
                                <option value="{{ $attraction->id }}">{{ $attraction->id }}</option>
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('showModalQueue')" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-secondary-button>

            <x-button class="ml-3" wire:click="saveQueue" wire:loading.attr="disabled" class="ml-2 text-green-600 bg-green-600">
                {{ __('Confirmar') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>