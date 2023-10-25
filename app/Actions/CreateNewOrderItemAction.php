<?php

namespace App\Actions;
use App\Models\OrderItem;

class CreateNewOrderItemAction
{
    public function handle(array $orderItemData): OrderItem
    {
        return OrderItem::create([
        ]);
    }
}
