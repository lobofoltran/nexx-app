<?php

namespace App\Actions;
use App\Models\ProductQueue;

class UpdateProductQueueAction
{
    public static function handle(ProductQueue $productQueue, array $productQueueData): ProductQueue
    {
        return $productQueue;
    }
}
