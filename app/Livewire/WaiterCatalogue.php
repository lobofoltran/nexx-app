<?php

namespace App\Livewire;

use App\Actions\CreateNewOrderAction;
use App\Models\Card;
use App\Models\Product;
use App\Models\ProductCategory;
use Livewire\Component;

class WaiterCatalogue extends Component
{
    public $card;
    public $items = [];
    public $search = '';
    public $productCategories;

    public function addItem(Product $product): void
    {
        $this->items[] = $product;
    }

    public function sendOrder(): void
    {
        CreateNewOrderAction::handle($this->card, $this->items);

        $this->items = [];
    }

    public function returnPage()
    {
        return $this->redirectRoute('waiter.card-view', ['id' => $this->card->id]);
    }

    public function render()
    {
        if (!$this->card) {
            $this->card = Card::find(request('id'));
        }

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
