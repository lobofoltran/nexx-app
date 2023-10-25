<?php

namespace App\Observers;

use App\Models\Affiliate;

class AffiliateObserver
{
    /**
     * Handle the Affiliate "created" event.
     */
    public function created(Affiliate $affiliate): void
    {
        //
    }

    /**
     * Handle the Affiliate "updated" event.
     */
    public function updated(Affiliate $affiliate): void
    {
        //
    }

    /**
     * Handle the Affiliate "deleted" event.
     */
    public function deleted(Affiliate $affiliate): void
    {
        //
    }

    /**
     * Handle the Affiliate "restored" event.
     */
    public function restored(Affiliate $affiliate): void
    {
        //
    }

    /**
     * Handle the Affiliate "force deleted" event.
     */
    public function forceDeleted(Affiliate $affiliate): void
    {
        //
    }
}
