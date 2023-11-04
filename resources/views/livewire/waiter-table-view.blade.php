<div>
    <div class="px-2">
        <x-button class="mb-2" wire:click="returnPage" wire:loading.attr="disabled">
            {{ __('Voltar') }}
        </x-button>
    </div>

    @if ($table)
    <hr>
        <div class="p-2 grid grid-cols-3 gap-1 my-2 text-white">
            @if ($table->status === TableStatus::Available->value || $table->status === TableStatus::InUse->value || $table->status === TableStatus::Grouped->value)
                <x-button wire:click="confirmAddCard" wire:loading.attr="disabled">
                    {{ __('Abrir Comanda') }}
                </x-button>
            @endif
            @if ($table->status === TableStatus::InUse->value || $table->status === TableStatus::Grouped->value)
                <x-button class="text-green-600 bg-green-600" wire:click="confirmGroupTables" wire:loading.attr="disabled">
                    {{ __('Agrupar Mesas') }}
                </x-button>
            @endif
                @if ($table->status === TableStatus::WaitingCleaning->value)
                <x-button wire:click="setAvalible" wire:loading.attr="disabled">
                    {{ __('Setar como Limpa') }}
                </x-button>
            @endif
        </div>
        <div class="bg-white dark:bg-gray-800 pt-4 px-4 border rounded">
            <div class="text-center text-lg">Mesa</div>
            <hr>
            <div class="my-4 visible-print text-center">
                {!! QrCode::generate($table->routeCostumer()) !!}
            </div>
            <div class="my-4"><b>• Mesa:</b> {{ $table->id }}</div>
            <div class="my-2 flex justify-between"><div><b>• Identificação:</b> {{ $table->identity }}</div></div>
            <div class="my-4"><b>• Tempo decorrido:</b> {{ $table->getTime() }}</div>
        </div>

        <div class="mt-2 bg-white dark:bg-gray-800 p-4 border rounded">
            <div class="text-center text-lg">Comandas</div>
            <hr>
            <table class="table w-full mt-3">
                <thead>
                    <tr>
                        <th>Comanda</th>
                        <th>Consumido</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($table->cards->where('status', CardStatus::Active->value) as $card)
                        <tr class="text-black border-b">
                            <td class="text-center">#{{ $card->id }} {{ $card->identity ? '(' . $card->identity . ')' : '' }}</td>
                            <td class="text-center">@money($card->getConsummation())</td>
                            <td class="text-center"><x-button wire:click="viewCard({{ $card }})">Visualizar</x-button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if (sizeof($table->groupments) > 0)
            <div class="mt-2 bg-white dark:bg-gray-800 p-4 border rounded">
                <div class="text-center text-lg">Agrupamentos de Mesas</div>
                <hr>
                <table class="table-fixed w-full mt-3">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Mesa</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($table->groupments as $groupment)
                            <tr class="text-black">
                                <td class="text-center">#{{ $groupment->table->id }}</td>
                                <td class="text-center">{{ $groupment->table->identity }}</td>
                                <td><x-button wire:click="viewTable({{ $groupment->table }})" class="text-center">Visualizar</x-button></td>
                                <td><x-button wire:click="removeGropment({{ $groupment }})" class="text-center"><i class="fas fa-trash"></i></x-button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <div class="mt-2 bg-white dark:bg-gray-800 p-4 border rounded">
            <div class="text-center text-lg">Pedidos</div>
            <hr>
            <table class="table w-full mt-3">
                <thead>
                    <tr>
                        <th>Comanda</th>
                        <th>Produto</th>
                        <th>Valor</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($table->cards->where('status', CardStatus::Active->value) as $card)
                        @foreach ($card->orders as $order)
                            @foreach ($order->orderItems as $item)
                            <tr class="text-black border-b">
                                <td class="text-center">#{{ $card->id }}</td>
                                <td class="text-center">{{ $item->product->name }}</td>
                                <td class="text-center">@money($item->value)</td>
                                <td class="text-center"><div class="p-1 rounded-md text-sm border {{ OrderItemsStatus::from($item->status)->color() }}">{{ OrderItemsStatus::from($item->status)->label() }}</div></td>
                            </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-2 bg-white dark:bg-gray-800 p-4 border rounded w-full">
            <div class="text-center text-lg">Movimentações</div>
            <hr>
            <table class="table-auto overflow-hidden mt-5">
                <thead class="text-sm">
                    <tr>
                        <th>Ação</th>
                        <th>Detalhes</th>
                        <th>ID</th>
                        <th>Dt. Hora</th>
                        <th>Usuário</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($table->movimentations->reverse()->take(20) as $movimentation)
                    <tr class="text-black text-sm border-b">
                        <td class="text-center">{{ $movimentation->action }}</td>
                        <td>{{ $movimentation->details }}</td>
                        <td>{{ $movimentation->model_id }}</td>
                        <td>@dateHour($movimentation->created_at)</td>
                        <td class="text-center">{{ $movimentation->user->name }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <x-dialog-modal wire:model.live="confirmingGroupTables">
            <x-slot name="title">
                {{ __('Agrupar Mesas') }}
            </x-slot>
    
            <x-slot name="content">
                @if ($tableNull)
                    <div class="text-red-500">• Obrigatório selecionar uma mesa!</div>
                @endif
                <div class="mt-4">
                    <x-label for="atcm_table_id" value="{{ __('Comanda a ser agrupada') }}" />
                    <select wire:model="atcm_table_id" id="atcm_table_id" class="mt-1 block w-3/4 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm'">
                        <option value=""></option>
                        @if ($tables)
                            @foreach ($tables as $table)
                                <option wire:click="setTableNullFalse" value="{{ $table->id }}">{{ $table->id }} {{ $table->identity ? '(' . $table->identity. ')' : ''}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </x-slot>
    
            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingGroupTables')" wire:loading.attr="disabled">
                    {{ __('Cancelar') }}
                </x-secondary-button>
    
                <x-button class="ml-3" wire:click="groupTable" wire:loading.attr="disabled" class="ml-2 text-green-600 bg-green-600">
                    {{ __('Agrupar') }}
                </x-button>
            </x-slot>
        </x-dialog-modal>    
    @else
        <x-error-message :title="__('Não foi possível completar sua requisição')" :text="__('Mesa não existe!')"></x-error-message>
    @endif
</div>
