<div>
    @if ($card)
    <div class="px-2">
        <x-button class="mb-2" wire:click="returnPage" wire:loading.attr="disabled" autofocus>
            {{ __('Voltar') }}
        </x-button>
    </div>
    @endif

    @if ($card && $card->status !== CardStatus::Closed->value)
        <hr>
            <div class="bg-white pt-4 px-4 border rounded">
                <div class="text-center text-lg">Área de Pagamentos</div>
                <hr>
                <div class="my-2"><b>• Comanda:</b> {{ $card->id }}</div>
                <div class="my-2 flex justify-between"><div><b>• Identificação:</b> {{ $card->identity }}</div></div>
                <div class="my-2 flex justify-between"><div><b>• Mesa:</b> {{ $card->table ? $card->table->id . ($card->table->identity ? ' (' . $card->table->identity. ')' : '') : '' }} </div></div>
                <div class="my-2 flex justify-end items-center"><span class="mr-2 text-sm">Subtotal</span> <span>@money($card->getConsummation())</span></div>

                @foreach ($card->groupments as $groupment)
                    <hr>
                    <div class="my-2"><b>• Comanda:</b> {{ $groupment->card->id }}</div>
                    <div class="my-2 flex justify-between"><div><b>• Identificação:</b> {{ $groupment->card->identity }}</div></div>
                    <div class="my-2 flex justify-between"><div><b>• Mesa:</b> {{ $groupment->card->table ? $groupment->card->table->id . ($groupment->card->table->identity ? ' (' . $groupment->card->table->identity. ')' : '') : '' }} </div></div>
                    
                    <div class="my-2 flex justify-end items-center"><span class="mr-2 text-sm">Subtotal</span> <span>@money($groupment->card->getConsummation())</span></div>
                @endforeach
                <hr class="my-4">
                <div class="mb-4 flex justify-between">
                    <div class="flex">
                        <x-button wire:click="removePerson" wire:loading.attr="disabled">-</x-button>
                        <div class="border p-2 px-4">{{ $this->quantityPerson }}</div>
                        <x-button wire:click="addPerson" wire:loading.attr="disabled">+</x-button>
                    </div>
                    <div class="my-2 text-center text-lg"><span class="text-sm">Total p/ pessoa</span> @money($card->getConsummation() / $this->quantityPerson)</div>
                </div>
                <hr class="my-4">
                <div class="mb-4">
                    <div class="my-2 flex justify-end items-center"><span class="mr-2 text-sm">Subtotal</span> <span>@money($card->getConsummationTotal())</span></div>
                    <div class="my-2 flex justify-end items-center"><span class="mr-2 text-sm">Pago</span> <span>@money($card->getPaidTotal())</span></div>
                    <div class="my-2 flex justify-end items-center"><span class="mr-2 text-sm">Troco</span> <span>@money($card->getTransshipmentTotal())</span></div>
                    <div class="my-2 flex justify-end items-center"><span class="mr-2 text-sm">Faltante</span> <span>@money($card->getMissingTotal())</span></div>
                </div>
                @if ($card->getConsummationTotal() <= $card->getPaidTotal())
                    <div class="p-2 my-2">
                        <x-button wire:click="confirmCloseCard" class="w-full">
                            {{ __('Encerrar Comanda(s)') }}
                        </x-button>
                    </div>
                @endif
            </div>
        <hr>
        <div class="mt-2 bg-white p-4 border rounded">
            <div class="text-center text-lg">Pedidos</div>
            <hr>
            @foreach ($card->orders as $order)
                @foreach ($order->orderItems as $item)
                    <div wire:click="addToCalculator({{ $item }})" class="flex justify-between p-4 border-neutral-200 w-full cursor-pointer border-b text-black mt-2">
                        <div>#{{ $card->id }}</div>
                        <div>{{ $item->product->name }}</div>
                        <div>{{ OrderItemsStatus::from($item->status)->label() }}</div>
                        <div>@money($item->value)</div>
                    </div>
                @endforeach
            @endforeach
            @foreach ($card->groupments as $groupment)
                @foreach ($groupment->card->orders as $order)
                    @foreach ($order->orderItems as $item)
                        <div wire:click="addToCalculator({{ $item }})" class="flex justify-between p-4 border-neutral-200 w-full cursor-pointer border-b text-black mt-2">
                            <div>#{{ $groupment->card->id }}</div>
                            <div>{{ $item->product->name }}</div>
                            <div>{{ OrderItemsStatus::from($item->status)->label() }}</div>
                            <div>@money($item->value)</div>
                        </div>
                    @endforeach
                @endforeach
            @endforeach
        </div>
        <div class="mt-2 bg-white p-4 border rounded">
            <div class="text-center text-lg">Calcular p/ Pedidos</div>
            @if ($calculatorItems)
                @foreach ($calculatorItems as $key => $item)
                    <div class="px-4">
                        <div class="flex justify-between items-center border-neutral-200 text-black mt-2 w-full">
                            <div>{{ $item['item']->product->name }}</div>
                            <div>@money($item['value'])</div>
                        </div>
                        <div class="flex justify-between items-center border-neutral-200 border-b py-4 text-black w-full">
                            <div>@money($item['value'] * $item['percent'])</div>
                            <div class="flex">
                                <x-button wire:click="addPercentCalculatorItem({{ $key }}, false)" wire:loading.attr="disabled">-</x-button>
                                <div class="border py-1 px-2">{{ $item['percent'] }}</div>
                                <x-button wire:click="addPercentCalculatorItem({{ $key }}, true)" wire:loading.attr="disabled">+</x-button>
                            </div>
                            <div><x-button wire:click="removeCalculatorItem({{ $key }})"><i class="fa-solid fa-trash"></i></x-button></div>
                        </div>
                    </div>
                @endforeach
                <div class="my-2 flex justify-end items-center">
                    <span class="text-sm mr-2">Total</span>
                    <span>@money($calculatorItemsTotalValue)</span>
                </div>
                <hr>
                <div class="my-2 flex justify-between">
                    <div class="flex">
                        <x-button wire:click="addPersonCalculator(false)" wire:loading.attr="disabled">-</x-button>
                        <div class="border py-1 px-2">{{ $this->quantityPersonCalculator }}</div>
                        <x-button wire:click="addPersonCalculator(true)" wire:loading.attr="disabled">+</x-button>
                    </div>
                    <x-button wire:click="cleanCalculator" class="bg-red-600" wire:loading.attr="disabled">Limpar</x-button>
                    <div class="text-center"><span class="text-sm">Total p/ pessoa</span> <span>@money($calculatorItemsTotalValue / $this->quantityPersonCalculator)</span></div>
                </div>
            @else
                <div class="text-center mt-5 mb-3">Adicione pedidos clicando sob eles</div>
            @endif
        </div>
        <div class="p-2 my-2">
            <x-button wire:click="confirmAddPayment" class="w-full" wire:loading.attr="disabled">
                {{ __('Adicionar Pagamento') }}
            </x-button>
        </div>
        <div class="mt-2 bg-white dark:bg-gray-800 p-4 border rounded">
            <div class="text-center text-lg">Pagamentos</div>
            <hr>
            <table class="table w-full mt-5 border-separate border-spacing-2">
                <thead class="border-b">
                    <tr>
                        <th>Forma Pgto.</th>
                        <th>Valor</th>
                        <th>Troco</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($card->payments as $payment)
                    <tr class="text-black">
                        <td class="text-center">{{ $payment->paymentMethod->name }}</td>
                        <td class="text-center">@money($payment->value)</td>
                        <td class="text-center">@money($payment->transshipment)</td>
                        <td class="text-center"><span class="p-1 rounded-md text-sm border text-black {{ PaymentStatus::from($payment->status)->color() }}">{{ PaymentStatus::from($payment->status)->label() }}</span></td>
                        <td class="text-center">
                            @if (PaymentStatus::from($payment->status)->value === PaymentStatus::Concluded->value)
                                <x-button wire:click="confirmCancelPayment({{ $payment }})">Cancelar</x-button>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="h-32"></div>

        <x-dialog-modal wire:model.live="confirmingAddPayment">
            <x-slot name="title">
                {{ __('Adicionar Pagamento') }}
            </x-slot>
    
            <x-slot name="content">
                <div class="grid grid-cols-3 gap-4 mt-2 mb-4 text-white">
                    @foreach ($paymentMethods as $paymentMethod)
                        <div class="flex flex-col justify-between p-4 rounded-lg {{ $selectedPaymentMethod == $paymentMethod ? 'text-white bg-green-600 hover:bg-green-800' : 'text-black bg-white hover:bg-neutral-200' }} shadow-lg w-full cursor-pointer" wire:click="selectPaymentMethod({{ $paymentMethod }})">
                            <div class="text-center flex-none">{{ $paymentMethod->name }}</div>
                        </div>
                    @endforeach
                </div>
                @if ($needPaymentMethod)
                    <div class="text-red-500 mt-5 mb-2">• Obrigatório selecionar um método de pagamento!</div>
                @endif
                <hr>
                <div class="mt-4">
                    <x-label for="value" value="{{ __('Valor') }}" />
                    <x-input id="value" type="text" class="mt-1 block w-full" wire:model="value" readonly disabled/>
                </div>
                @if ($needValue)
                    <div class="text-red-500 mt-5 mb-2">• Obrigatório um valor!</div>
                @endif
                <div class="grid grid-cols-3 gap-2 mt-2 mb-4 text-black">
                    <div class="p-4 rounded-lg bg-white hover:bg-black hover:text-white shadow-lg cursor-pointer" wire:click="addValue(1)">
                        <div class="text-center flex-none">1</div>
                    </div>
                    <div class="p-4 rounded-lg bg-white hover:bg-black hover:text-white shadow-lg cursor-pointer" wire:click="addValue(2)">
                        <div class="text-center flex-none">2</div>
                    </div>
                    <div class="p-4 rounded-lg bg-white hover:bg-black hover:text-white shadow-lg cursor-pointer" wire:click="addValue(3)">
                        <div class="text-center flex-none">3</div>
                    </div>
                    <div class="p-4 rounded-lg bg-white hover:bg-black hover:text-white shadow-lg cursor-pointer" wire:click="addValue(4)">
                        <div class="text-center flex-none">4</div>
                    </div>
                    <div class="p-4 rounded-lg bg-white hover:bg-black hover:text-white shadow-lg cursor-pointer" wire:click="addValue(5)">
                        <div class="text-center flex-none">5</div>
                    </div>
                    <div class="p-4 rounded-lg bg-white hover:bg-black hover:text-white shadow-lg cursor-pointer" wire:click="addValue(6)">
                        <div class="text-center flex-none">6</div>
                    </div>
                    <div class="p-4 rounded-lg bg-white hover:bg-black hover:text-white shadow-lg cursor-pointer" wire:click="addValue(7)">
                        <div class="text-center flex-none">7</div>
                    </div>
                    <div class="p-4 rounded-lg bg-white hover:bg-black hover:text-white shadow-lg cursor-pointer" wire:click="addValue(8)">
                        <div class="text-center flex-none">8</div>
                    </div>
                    <div class="p-4 rounded-lg bg-white hover:bg-black hover:text-white shadow-lg cursor-pointer" wire:click="addValue(9)">
                        <div class="text-center flex-none">9</div>
                    </div>
                    <div class="p-4 rounded-lg bg-red-700 hover:bg-red-900 text-white shadow-lg cursor-pointer" wire:click="clean">
                        <div class="text-center flex-none">Limpar</div>
                    </div>
                    <div class="p-4 rounded-lg bg-white hover:bg-black hover:text-white shadow-lg cursor-pointer" wire:click="addValue(0)">
                        <div class="text-center flex-none">0</div>
                    </div>
                    <div class="p-4 rounded-lg bg-white hover:bg-black hover:text-white shadow-lg cursor-pointer" wire:click="addValue('.')">
                        <div class="text-center flex-none">,</div>
                    </div>
                    <div class="p-4 rounded-lg bg-white hover:bg-black hover:text-white shadow-lg cursor-pointer" wire:click="addValue(10, false)">
                        <div class="text-center flex-none">+10</div>
                    </div>
                    <div class="p-4 rounded-lg bg-white hover:bg-black hover:text-white shadow-lg cursor-pointer" wire:click="addValue(50, false)">
                        <div class="text-center flex-none">+50</div>
                    </div>
                    <div class="p-4 rounded-lg bg-white hover:bg-black hover:text-white shadow-lg cursor-pointer" wire:click="addValue(100, false)">
                        <div class="text-center flex-none">+100</div>
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingAddPayment')" wire:loading.attr="disabled">
                    {{ __('Cancelar') }}
                </x-secondary-button>
    
                <x-button class="ml-3" wire:click="addPayment" wire:loading.attr="disabled" class="ml-2 text-green-600 bg-green-600">
                    {{ __('Adicionar') }}
                </x-button>
            </x-slot>
    
        </x-dialog-modal>

        <x-dialog-modal wire:model.live="confirmingCancelPayment">
            <x-slot name="title">
                {{ __('Cancelar Pagamento') }}
            </x-slot>
    
            <x-slot name="content">
                Tem certeza que deseja cancelar o pagamento?
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingCancelPayment')" wire:loading.attr="disabled">
                    {{ __('Não') }}
                </x-secondary-button>
    
                <x-button class="ml-3" wire:click="cancelPayment" wire:loading.attr="disabled" class="ml-2 bg-red-600">
                    {{ __('Cancelar') }}
                </x-button>
            </x-slot>
    
        </x-dialog-modal>

        <x-dialog-modal wire:model.live="confirmingCloseCard">
            <x-slot name="title">
                {{ __('Encerrar Comanda') }}
            </x-slot>
    
            <x-slot name="content">
                Tem certeza que deseja encerrar a comanda?
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingCloseCard')" wire:loading.attr="disabled">
                    {{ __('Cancelar') }}
                </x-secondary-button>
    
                <x-button class="ml-3" wire:click="closeCard" wire:loading.attr="disabled" class="ml-2 bg-green-600">
                    {{ __('Encerrar') }}
                </x-button>
            </x-slot>
    
        </x-dialog-modal>

    @else
        <x-error-message :title="__('Não foi possível completar sua requisição')" :text="$card ? __('Comanda encerrada!') : __('Comanda não existe!')"></x-error-message>
    @endif
</div>
