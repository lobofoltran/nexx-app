<?php

namespace App\Observers;

use App\Models\OrderItemQueue;

class OrderItemQueueObserver
{
    /**
     * Handle the OrderItemQueue "created" event.
     */
    public function created(OrderItemQueue $OrderItemQueue): void
    {
        //
    }

    /**
     * Handle the OrderItemQueue "updated" event.
     */
    public function updated(OrderItemQueue $OrderItemQueue): void
    {
        //
    }

    /**
     * Handle the OrderItemQueue "deleted" event.
     */
    public function deleted(OrderItemQueue $OrderItemQueue): void
    {
        //
    }

    /**
     * Handle the OrderItemQueue "restored" event.
     */
    public function restored(OrderItemQueue $OrderItemQueue): void
    {
        //
    }

    /**
     * Handle the OrderItemQueue "force deleted" event.
     */
    public function forceDeleted(OrderItemQueue $OrderItemQueue): void
    {
        //
    }
}
