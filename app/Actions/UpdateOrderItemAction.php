<?php

namespace App\Actions;
use App\Models\OrderItem;

class UpdateOrderItemAction
{
    public static function handle(OrderItem $orderItem, array $orderItemData): OrderItem
    {
        return $orderItem;
    }
}
