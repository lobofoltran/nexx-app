<?php

namespace App\Actions;
use App\Models\Order;

class CreateNewOrderAction
{
    public function handle(array $orderData): Order
    {
        return Order::create([
        ]);
    }
}
