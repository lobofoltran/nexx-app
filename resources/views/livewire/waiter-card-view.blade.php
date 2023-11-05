<div>
    <div class="px-2">
        <x-button class="mb-2" wire:click="returnPage" wire:loading.attr="disabled" autofocus>
            {{ __('Voltar') }}
        </x-button>
    </div>

    @if ($card)
    <hr>
    @if ($card->status !== CardStatus::Closed->value)
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

            <x-button wire:click="printCard" wire:loading.attr="disabled">
                {{ __('Imprimir') }}
            </x-button>
        </div>
    @else
        <div class="p-2 grid grid-cols-1 gap-1 my-2 text-white">
            <x-button wire:click="printCard" wire:loading.attr="disabled">
                {{ __('Imprimir') }}
            </x-button>
        </div>
        <div class="bg-white text-gray-900 py-4 border rounded text-center my-2 text-lg font-medium dark:text-gray-100">Comanda encerrada</div>
    @endif
        <div class="bg-white dark:bg-gray-800 pt-4 px-4 border rounded">
            <div class="text-center text-lg">Comanda</div>
            <hr>
            <div class="my-4 visible-print text-center">
                {!! QrCode::generate($card->routeCostumer()) !!}
            </div>
            <div class="my-4"><b>• Comanda:</b> {{ $card->id }}</div>
            <div class="my-2 flex justify-between"><div><b>• Identificação:</b> {{ $card->identity }}</div> 
                @if ($card->status !== CardStatus::Closed->value) 
                    <x-button wire:click="confirmEditIdentity" wire:loading.attr="disabled">{{ __('Editar') }}</x-button>
                @endif
            </div>
            <div class="my-2 flex justify-between"><div><b>• Comanda Física:</b> {{ $card->cardPhysical ? $card->cardPhysical->id : '' }}</div> 
                @if ($card->status !== CardStatus::Closed->value) 
                    <div>
                        @if ($card->cardPhysical)
                            <x-button wire:click="viewCardPhysical" wire:loading.attr="disabled">{{ __('Visualizar') }}</x-button>
                        @endif
                        <x-button wire:click="confirmEditCardPhysical" wire:loading.attr="disabled">{{ __('Editar') }}</x-button>
                    </div>
                @endif
            </div>
            <div class="my-2 flex justify-between"><div><b>• Mesa:</b> {{ $card->table ? $card->table->id . ($card->table->identity ? ' (' . $card->table->identity. ')' : '') : '' }} </div> 
                @if ($card->status !== CardStatus::Closed->value) 
                    <div>
                        @if ($card->table)
                            <x-button wire:click="viewTable" wire:loading.attr="disabled">{{ __('Visualizar') }}</x-button>
                        @endif
                        <x-button wire:click="confirmEditTable" wire:loading.attr="disabled">{{ __('Editar') }}</x-button>
                    </div>    
                @endif
            </div>
            <div class="my-4"><b>• Tempo decorrido:</b> {{ $card->getTime() }}</div>
            <div class="my-4"><b>• Subtotal: </b> @money($card->getConsummation())</div>
            <div class="my-4"><b>• Pago: </b> @money($card->getPaid())</div>
            <div class="my-4"><b>• Troco: </b> @money($card->getTransshipment())</div>
        </div>
        @if (sizeof($card->groupments) > 0)
            <div class="mt-2 bg-white dark:bg-gray-800 p-4 border rounded">
                <div class="text-center text-lg">Agrupamentos de Comandas</div>
                <hr>
                <table class="table-fixed w-full mt-3">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Comanda</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($card->groupments as $groupment)
                        <tr class="text-black">
                            <td class="text-center">#{{ $groupment->card->id }}</td>
                            <td class="text-center">{{ $groupment->card->identity }}</td>
                            <td><x-button wire:click="viewCard({{ $groupment->card }})" class="text-center">Visualizar</x-button></td>
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
                        <th>Produto</th>
                        <th>Valor</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($card->orders as $order)
                        @foreach ($order->orderItems as $item)
                        <tr class="text-black border-b">
                            <td class="text-center">{{ $item->product->name }}</td>
                            <td class="text-center">@money($item->value)</td>
                            <td class="text-center"><div class="p-1 rounded-md text-sm border text-black {{ OrderItemsStatus::from($item->status)->color() }}">{{ OrderItemsStatus::from($item->status)->label() }}</div></td>
                        </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-2 bg-white dark:bg-gray-800 p-4 border rounded">
            <div class="text-center text-lg">Pagamentos</div>
            <hr>
            <table class="table w-full mt-3 border-separate border-spacing-2">
                <thead class="border-b">
                    <tr>
                        <th>Forma Pgto.</th>
                        <th>Valor</th>
                        <th>Troco</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($card->payments as $payment)
                    <tr class="text-black">
                        <td class="text-center">{{ $payment->paymentMethod->name }}</td>
                        <td class="text-center">@money($payment->value)</td>
                        <td class="text-center">@money($payment->transshipment)</td>
                        <td class="text-center"><span class="p-1 rounded-md text-sm border text-black {{ PaymentStatus::from($payment->status)->color() }}">{{ PaymentStatus::from($payment->status)->label() }}</span></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-2 bg-white dark:bg-gray-800 p-4 border rounded">
            <div class="text-center text-lg">Movimentações</div>
            <hr>
            <table class="table w-full mt-5 border-separate border-spacing-2">
                <thead class="border-b text-sm">
                    <tr>
                        <th>Detalhes</th>
                        <th>ID</th>
                        <th>Dt. Hora</th>
                        <th>Usuário</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($card->movimentations->reverse()->take(20) as $movimentation)
                    <tr class="text-black text-sm">
                        <td>{{ $movimentation->details }}</td>
                        <td>{{ $movimentation->model_id }}</td>
                        <td>@dateHour($movimentation->created_at)</td>
                        <td class="text-center">{{ $movimentation->user->name }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <x-dialog-modal wire:model.live="confirmingEditIdentity">
            <x-slot name="title">
                {{ __('Editar Identificação') }}
            </x-slot>
    
            <x-slot name="content">
                <div class="mt-4">
                    <x-label for="identity" value="{{ __('Identificação') }}" />
                    <x-input id="identity" type="text" class="mt-1 block w-3/4" wire:model="identity"/>
                </div>
            </x-slot>
    
            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingEditIdentity')" wire:loading.attr="disabled">
                    {{ __('Cancelar') }}
                </x-secondary-button>
    
                <x-button class="ml-3" wire:click="editIdentity" wire:loading.attr="disabled" class="ml-2 text-green-600 bg-green-600">
                    {{ __('Salvar') }}
                </x-button>
            </x-slot>
        </x-dialog-modal>

        <x-dialog-modal wire:model.live="confirmingEditCardPhysical">
            <x-slot name="title">
                {{ __('Editar Comanda Física') }}
            </x-slot>
    
            <x-slot name="content">
                <div class="mt-4">
                    <x-label for="newCardPhysical" value="{{ __('Comanda Física') }}" />
                    <select wire:model="newCardPhysical" id="newCardPhysical" class="mt-1 block w-3/4 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm'">
                        <option value="">Sem Comanda Física</option>
                        @foreach ($cardsPhysical as $cardPhysical)
                            <option value="{{ $cardPhysical->id }}">{{ $cardPhysical->id }}</option>
                        @endforeach
                    </select>
                </div>
            </x-slot>
    
            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingEditCardPhysical')" wire:loading.attr="disabled">
                    {{ __('Cancelar') }}
                </x-secondary-button>
    
                <x-button class="ml-3" wire:click="editCardPhysical" wire:loading.attr="disabled" class="ml-2 text-green-600 bg-green-600">
                    {{ __('Salvar') }}
                </x-button>
            </x-slot>
        </x-dialog-modal>


        <x-dialog-modal wire:model.live="confirmingEditTable">
            <x-slot name="title">
                {{ __('Editar Mesa') }}
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
            </x-slot>
        
        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingEditTable')" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-secondary-button>

            <x-button class="ml-3" wire:click="editTable" wire:loading.attr="disabled" class="ml-2 text-green-600 bg-green-600">
                {{ __('Salvar') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>

    <x-dialog-modal wire:model.live="confirmingGroupCards">
        <x-slot name="title">
            {{ __('Agrupar Comandas') }}
        </x-slot>

        <x-slot name="content">
            @if ($cardNull)
                <div class="text-red-500">• Obrigatório selecionar uma comanda!</div>
            @endif
            <div class="mt-4">
                <x-label for="atcm_card_id" value="{{ __('Comanda a ser agrupada') }}" />
                <select wire:model="atcm_card_id" id="atcm_card_id" class="mt-1 block w-3/4 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm'">
                    <option value=""></option>
                    @foreach ($cards as $card)
                        <option wire:click="setCardNullFalse" value="{{ $card->id }}">{{ $card->id }} {{ $card->identity ? '(' . $card->identity. ')' : ''}}</option>
                    @endforeach
                </select>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingGroupCards')" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-secondary-button>

            <x-button class="ml-3" wire:click="groupCard" wire:loading.attr="disabled" class="ml-2 text-green-600 bg-green-600">
                {{ __('Agrupar') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>

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
                    @foreach ($tables as $table)
                        <option wire:click="setTableNullFalse" value="{{ $table->id }}">({{ TableStatus::from($table->status)->label() }}) {{ $table->id }} {{ $table->identity ? '(' . $table->identity. ')' : ''}}</option>
                    @endforeach
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
        <x-error-message :title="__('Não foi possível completar sua requisição')" :text="__('Comanda não existe!')"></x-error-message>
    @endif
</div>
