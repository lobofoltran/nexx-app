<?php

namespace App\Livewire;

use App\Actions\CreateNewCallAction;
use App\Actions\CreateNewOrderAction;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class CostumerCatalogue extends Component
{
    public $url;
    public $items;
    public $type;
    public $table;
    public $card;
    public $productCategories;
    public $selectedCategory;
    public $fontSize;
    public $stylePage = 'invertido';

    public function renderFont()
    {

    }

    public function solicitarFechamento()
    {
        CreateNewCallAction::handle($this->card->table, 'Fechamento da Comanda');
    }

    public function chamarGarcom()
    {
        CreateNewCallAction::handle($this->card->table, 'Chamando Garçom');
    }

    public function returnPage()
    {
        return redirect($this->url);
    }

    public function addItem(Product $product)
    {
        $this->items[] = $product;
    }

    public function removeItemCart(string $key): void
    {
        unset($this->items[$key]);
    }

    public function sendOrder(): void
    {
        CreateNewOrderAction::handle($this->card, $this->items);

        $this->items = [];
    }

    public function selectCategory(ProductCategory $productCategory)
    {
        $this->selectedCategory = $productCategory;
    }

    public function mount()
    {
        $this->url = url()->previous();
        $this->type = Session::get('costumer')['type'];
        $this->card = Session::get('costumer')['data'];
        $this->productCategories = ProductCategory::all();
        $this->selectedCategory = $this->productCategories->first();

        if ($this->type === 'card.virtual') {
            $this->table = $this->card->table ??false;
        } else if ($this->type === 'card.physical') {
            $this->table = $this->card->currentCard()->first()->table ??false;
        } else if ($this->type === 'card.table') {
            $this->table = true;
        } else {
            $this->table = false;
        }
    }

    public function render()
    {
        return view('livewire.costumer-catalogue');
    }
}
