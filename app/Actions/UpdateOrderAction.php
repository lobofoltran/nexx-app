<?php

namespace App\Actions;
use App\Models\Order;

class UpdateOrderAction
{
    public static function handle(Order $order, array $orderData): Order
    {
        return $order;
    }
}
