<?php

namespace App\Actions;
use App\Models\OrderItem;

class CreateNewOrderItemAction
{
    public static function handle(array $orderItemData): OrderItem
    {
        return OrderItem::create([
        ]);
    }
}
