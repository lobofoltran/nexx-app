<?php

namespace App\Actions;
use App\Models\Order;

class CreateNewOrderAction
{
    public static function handle(array $orderData): Order
    {
        return Order::create([
        ]);
    }
}
