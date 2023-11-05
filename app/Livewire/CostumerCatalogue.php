<?php

namespace App\Livewire;

use App\Actions\CreateNewOrderAction;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class CostumerCatalogue extends Component
{
    public $items;
    public $type;
    public $card;
    public $productCategories;
    public $selectedCategory;
    public $fontSize;
    public $stylePage = 'invertido';

    public function renderFont()
    {

    }

    public function returnPage()
    {
        return redirect()->route('costumer.card.virtual', ['card' => $this->card->uuid]);
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
        $this->type = Session::get('costumer')['type'];
        $this->card = Session::get('costumer')['data'];
        $this->productCategories = ProductCategory::all();
        $this->selectedCategory = $this->productCategories->first();
    }

    public function render()
    {
        return view('livewire.costumer-catalogue');
    }
}
