<div>
    @if ($card && $card->status !== CardStatus::Closed->value)
        <div class="px-2">
            <x-button class="mb-2" wire:click="returnPage" wire:loading.attr="disabled" autofocus>
                {{ __('Voltar') }}
            </x-button>
        </div>
        <hr>
            <div class="bg-white dark:bg-gray-800 pt-4 px-4 border rounded">
                <div class="text-center text-lg">Novo Pedido</div>
                <hr>
                <div class="my-4"><b>• Comanda:</b> {{ $card->id }}</div>
                <div class="my-4"><b>• Itens:</b></div>
                <?php $total = 0 ?>
                @foreach ($items as $key => $item)
                    <div class="flex justify-between py-1 border-b text-black uppercase text-center">
                        <div>{{ $item->name }}</div>
                        <div>@money($item->value)</div>
                        <div><x-button wire:click="removeItemCart({{ $key }})"><i class="fas fa-trash"></i></x-button></div>
                        <?php $total += $item->value ?>
                    </div>
                @endforeach
                @if ($items)
                    <hr>
                    <div class="my-2 flex justify-end">
                        Subtotal: @money($total)
                    </div>
                    <hr>
                    <div class="my-2 flex justify-end">
                        <x-button wire:click="sendOrder" wire:loading.attr="disabled">
                            {{ __('Enviar Pedido') }}
                        </x-button>
                    </div>
                @endif
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
                    id="product" 
                    class="block mt-1 w-full pl-10 py-2 px-3" 
                    type="text" 
                    name="product" 
                    autofocus
                    placeholder="{{ __('Pesquisar produtos') }}"/>
            </div>
        </div>

        <div class="w-full">
            <div>
                @foreach ($productCategories as $key => $category)
                    <div class="py-1 border-neutral-200 bg-blue-500 text-white uppercase text-center rounded">
                        {{ $category->description }}
                    </div>
                    @foreach ($category->products as $product)
                        <div class="flex justify-between pt-1 border-b border-neutral-200 text-black uppercase text-center">
                            <div>{{ $product->name }}</div>
                            <div>@money($product->value)</div>

                            <x-button class="mb-2" wire:click="addItem({{ $product }})" wire:loading.attr="disabled">
                                {{ __('Adicionar') }}
                            </x-button>            
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    @else
        @if ($card)
            <div class="px-2">
                <x-button class="mb-2" wire:click="returnPage" wire:loading.attr="disabled" autofocus>
                    {{ __('Voltar') }}
                </x-button>
            </div>
        @endif
        <x-error-message :title="__('Não foi possível completar sua requisição')" :text="$card ? __('Comanda encerrada!') : __('Comanda não existe!')"></x-error-message>
    @endif
</div>
