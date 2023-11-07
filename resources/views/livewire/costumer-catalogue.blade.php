<div class="min-h-screen {{ $stylePage == 'invertido' ? 'bg-gray-100' : 'bg-gray-800 text-white' }} {{ $fontSize }}">
    <header class="{{ $stylePage == 'invertido' ? 'bg-white-800 text-black' : 'bg-gray-900' }} shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            @if ($type == 'card.virtual')
                Comanda #{{ $card->id }} 
                @if ($card->identity)
                    ({{$card->identity}})
                @endif
            @elseif ($type == 'card.physical')
                Comanda #{{ $card->id }} 
                @if ($card->code)
                    ({{$card->code}})
                @endif
            @elseif ($type == 'table')
                Mesa #{{ $card->id }} 
                @if ($card->identity)
                    ({{$card->identity}})
                @endif
            @endif
        </div>
    </header>
    <main>
        <div class="max-w-2xl mx-auto mt-4">
            <div class="px-2">
                <x-button class="mb-2" wire:click="returnPage" wire:loading.attr="disabled" autofocus class="{{ $stylePage == 'invertido' ? '' : 'bg-grey-900 text-black' }}">
                    {{ __('Voltar') }}
                </x-button>
            </div>
            <hr class="my-2">

            <div class="flex p-2">
                <div class="mr-2">
                    <x-label for="style" value="{{ __('Cores da Página') }}" class="{{ $stylePage == 'invertido' ? '' : 'text-white' }}"/>
                    <select wire:model="stylePage" wire:click="renderFont" id="style" class="{{ $stylePage == 'invertido' ? '' : 'text-black' }} block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'">
                        <option selected value="invertido">Normal</option>
                        <option value="normal">Fortes</option>
                    </select>
                </div>

                <div>
                    <x-label for="font" value="{{ __('Tamanho da Fonte') }}" class="{{ $stylePage == 'invertido' ? '' : 'text-white' }}"/>
                    <select wire:model="fontSize" wire:click="renderFont" id="font" class="{{ $stylePage == 'invertido' ? '' : 'text-black' }} block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'">
                        <option value="text-base">Normal</option>
                        <option value="text-lg">Grande</option>
                        <option value="text-xl">Extra Grande</option>
                    </select>
                </div>

            </div>
            <hr class="my-2">

            <hr>
            <div class="{{ $stylePage == 'invertido' ? 'bg-white' : 'bg-gray-800' }} pt-4 px-4 mb-3 border rounded">
                <div class="text-center text-lg">Novo Pedido</div>
                <hr>
                <div class="my-4"><b>• Itens:</b></div>
                @if ($items)
                <?php $total = 0 ?>
                @foreach ($items as $key => $item)
                    <div class="flex justify-between py-1 border-b {{ $stylePage == 'invertido' ? 'text-black' : 'text-white' }} uppercase text-center">
                        <div>{{ $item->name }}</div>
                        <div>@money($item->value)</div>
                        <div><x-button class="{{ $stylePage == 'invertido' ? '' : 'bg-red-500' }}" wire:click="removeItemCart({{ $key }})"><i class="fas fa-trash"></i></x-button></div>
                        <?php $total += $item->value ?>
                    </div>
                @endforeach
                    <hr>
                    <div class="my-2 flex justify-end">
                        Subtotal: @money($total)
                    </div>
                    <hr>
                    @if ($type == 'card.virtual')                        
                        <div class="my-2 flex justify-end">
                            <x-button class="{{ $stylePage == 'invertido' ? '' : 'bg-green-500' }}" wire:click="sendOrder" wire:loading.attr="disabled">
                                {{ __('Enviar Pedido') }}
                            </x-button>
                        </div>
                    @else
                        @if ($table)
                            <x-button class="my-2 text-2xl w-full" wire:click="chamarGarcom">CHAMAR O GARÇOM</x-button>
                        @else
                            <div class="my-2 text-center">
                                Entre em contato com um garçom para realizar seu pedido!
                            </div>
                        @endif
                    @endif
                @endif
            </div>
            <hr class="my-2">
            <div class="w-full">
                <ul class="px-2">
                    @foreach ($productCategories as $key => $category)
                    <li wire:click="selectCategory({{ $category }})" 
                        class="cursor-pointer transition duration-300 py-1 border-b border-neutral-200 uppercase text-center
                        {{ $category->id === $selectedCategory->id ? ($stylePage == 'invertido' ? 'bg-blue-600 hover:bg-blue-700 text-white' : 'bg-blue-800 hover:bg-blue-900 text-white') : ($stylePage == 'invertido' ? 'bg-zinc-400 hover:bg-zinc-500 text-white' : 'bg-zinc-100 hover:bg-zinc-200 text-black') }}
                        @if ($key === 0) rounded-t @endif
                        @if ($key === count($productCategories) - 1) rounded-b @endif">
                        {{ $category->description }}
                    </li>
                    @endforeach
                </ul>
            </div>
            <hr class="my-2">
            <!-- Painel de Pedidos da Categoria Selecionada -->
            <div class="w-full mt-2 mb-5">
                <ul class="px-2">
                    @forelse ($selectedCategory->products->where('active', true) as $product)
                    <li class="mb-2 transition duration-300 rounded-lg shadow-lg {{ $stylePage == 'invertido' ? 'bg-neutral-200 text-black' : 'bg-gray-800 text-white' }}">
                        <div class="flex flex-row justify-between items-center">
                            <div class="w-1/5 md:w-1/3 h-full">
                                <img src="/storage/{{ $product->image_url }}" alt="{{ $product->name }}" class="rounded w-full h-full object-cover m-auto max-w-32 max-h-32 overflow-hidden">
                            </div>
                            <div class="w-4/5 md:w-2/3 md:pl-4">
                                <div class="flex justify-between items-center px-2 py-1">
                                    <h3 class="font-semibold uppercase">{{ $product->name }}</h3>
                                    <p class="font-semibold">@money($product->value)</p>
                                </div>
                                <div class="px-2 py-1">
                                    <p class="text-sm">{{ $product->description }}</p>
                                </div>
                                <div class="p-2 flex justify-end">
                                    <button wire:click="addItem({{ $product }})" class="bg-blue-600 text-white px-2 py-1 rounded hover:bg-blue-700 transition duration-300 uppercase text-xs font-semibold">Adicionar ao pedido</button>
                                </div>
                            </div>
                        </div>
                    </li>
                    @empty
                        <li class="mb-2 bg-neutral-200 text-black transition duration-300 rounded shadow-lg">
                            <p class="text-center p-5">Nenhum produto encontrado</p>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
        <div class="{{ $stylePage == 'invertido' ? '' : 'bg-gray-800' }}">.</div>
    </main>
</div>
