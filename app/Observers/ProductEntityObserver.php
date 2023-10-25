<?php

namespace App\Observers;

use App\Models\ProductEntity;

class ProductEntityObserver
{
    /**
     * Handle the ProductEntity "created" event.
     */
    public function created(ProductEntity $productEntity): void
    {
        //
    }

    /**
     * Handle the ProductEntity "updated" event.
     */
    public function updated(ProductEntity $productEntity): void
    {
        //
    }

    /**
     * Handle the ProductEntity "deleted" event.
     */
    public function deleted(ProductEntity $productEntity): void
    {
        //
    }

    /**
     * Handle the ProductEntity "restored" event.
     */
    public function restored(ProductEntity $productEntity): void
    {
        //
    }

    /**
     * Handle the ProductEntity "force deleted" event.
     */
    public function forceDeleted(ProductEntity $productEntity): void
    {
        //
    }
}
