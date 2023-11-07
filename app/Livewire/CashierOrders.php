<?php

namespace App\Livewire;

use App\Enums\OrderItemsStatus;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Services\OrderItemService;
use Livewire\Component;

class CashierOrders extends Component
{
    public $search;
    public $orderItems;
    public $confirmMark = false;
    public $confirmItem;

    public function confirmingMark(OrderItem $orderItem)
    {
        if (!$this->confirmMark) {
            $this->confirmItem = $orderItem;
        }

        $this->confirmMark = !$this->confirmMark;
    }

    public function setRejected()
    {
        if ($this->confirmItem) {
            OrderItemService::setRejected($this->confirmItem);
        }
    }

    public function setPreparing()
    {
        if ($this->confirmItem) {
            OrderItemService::setPreparing($this->confirmItem);
        }
    }

    public function setConcluded()
    {
        if ($this->confirmItem) {
            OrderItemService::setConcluded($this->confirmItem);
            $this->confirmMark = false;
            $this->confirmItem = null;
        }
    }

    public function setCanceled()
    {
        if ($this->confirmItem) {
            OrderItemService::setCanceled($this->confirmItem);
        }
    }

    public function render()
    {
        $categories = ProductCategory::where('is_attraction', false)->get('id');
        $products = Product::query()
            ->where('show_to_cashier', true)
            ->whereIn('atcm_products_categories_id', $categories)
            ->get('id');

        if ($this->search) {
            $this->orderItems = OrderItem::query()
                ->whereIn('atcm_product_id', $products)
                ->whereRelation('product', 'name', 'LIKE', '%'. $this->search .'%')
                ->orWhere('id', 'LIKE', '%'. $this->search .'%')
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $this->orderItems = OrderItem::query()
                ->whereIn('status', [OrderItemsStatus::Assessing->value, OrderItemsStatus::Preparing->value])
                ->whereIn('atcm_product_id', $products)
                ->orderBy('id', 'desc')
                ->get();
        }
        
        return view('livewire.cashier-orders');
    }
}
