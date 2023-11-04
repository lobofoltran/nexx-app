<?php

namespace App\Livewire;

use App\Enums\OrderItemsStatus;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Services\OrderItemService;
use Livewire\Component;

class WaiterOrder extends Component
{
    public $search;
    public $orderItems = [];
    public $confirmMark = false;
    public $confirmItem;

    public function confirmingMark(OrderItem $orderItem)
    {
        if (!$this->confirmMark) {
            $this->confirmItem = $orderItem;
        }

        $this->confirmMark = !$this->confirmMark;
    }

    public function setDelivered()
    {
        if ($this->confirmItem) {
            OrderItemService::setDelivered($this->confirmItem);
            $this->confirmMark = false;
            $this->confirmItem = null;
        }
    }

    public function setCanceled()
    {
        if ($this->confirmItem) {
            OrderItemService::setCanceled($this->confirmItem);
            $this->confirmMark = false;
            $this->confirmItem = null;
        }
    }
    
    public function render()
    {
        $categories = ProductCategory::where('is_attraction', false)->get('id');
        $products = Product::whereIn('atcm_products_categories_id', $categories)->get('id');

        if ($this->search) {
            $this->orderItems = OrderItem::whereIn('atcm_product_id', $products)
                ->whereRelation('product', 'name', 'LIKE', '%'. $this->search .'%')
                ->orWhere('id', 'LIKE', '%'. $this->search .'%')
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $this->orderItems = OrderItem::where('status', OrderItemsStatus::Concluded->value)
            ->whereIn('atcm_product_id', $products)
            ->orderBy('id', 'desc')
            ->get();
        }

        return view('livewire.waiter-order');
    }
}
