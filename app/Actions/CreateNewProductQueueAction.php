<?php

namespace App\Actions;
use App\Models\ProductQueue;

class CreateNewProductQueueAction
{
    public function handle(array $productQueueData): ProductQueue
    {
        return ProductQueue::create([
        ]);
    }
}
