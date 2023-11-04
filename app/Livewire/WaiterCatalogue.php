<?php

namespace App\Livewire;

use App\Actions\CreateNewOrderAction;
use App\Models\Card;
use App\Models\Product;
use App\Models\ProductCategory;
use Livewire\Component;

class WaiterCatalogue extends Component
{
    public $route;
    public $card;
    public $items = [];
    public $search = '';
    public $productCategories;

    public function addItem(Product $product): void
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

    public function returnPage()
    {
        redirect($this->route);
    }
    
    public function mount()
    {
        $this->route = url()->previous();

        if (!$this->card) {
            $this->card = Card::find(request('card'));
        }
    }

    public function render()
    {
        $this->productCategories = ProductCategory::all();

        if ($this->search) {
            $products = Product::where('name', 'like', '%'.$this->search.'%')->get('atcm_products_categories_id');

            $this->productCategories = ProductCategory::whereIn('id', $products)->get();
        } else {
            $this->productCategories = ProductCategory::all();
        }
        return view('livewire.waiter-catalogue');
    }
}
