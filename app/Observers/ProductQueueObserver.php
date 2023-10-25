<?php

namespace App\Observers;

use App\Models\ProductQueue;

class ProductQueueObserver
{
    /**
     * Handle the ProductQueue "created" event.
     */
    public function created(ProductQueue $productQueue): void
    {
        //
    }

    /**
     * Handle the ProductQueue "updated" event.
     */
    public function updated(ProductQueue $productQueue): void
    {
        //
    }

    /**
     * Handle the ProductQueue "deleted" event.
     */
    public function deleted(ProductQueue $productQueue): void
    {
        //
    }

    /**
     * Handle the ProductQueue "restored" event.
     */
    public function restored(ProductQueue $productQueue): void
    {
        //
    }

    /**
     * Handle the ProductQueue "force deleted" event.
     */
    public function forceDeleted(ProductQueue $productQueue): void
    {
        //
    }
}
