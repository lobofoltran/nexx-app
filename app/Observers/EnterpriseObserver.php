<?php

namespace App\Observers;

use App\Models\Enterprise;

class EnterpriseObserver
{
    /**
     * Handle the Enterprise "created" event.
     */
    public function created(Enterprise $enterprise): void
    {
        //
    }

    /**
     * Handle the Enterprise "updated" event.
     */
    public function updated(Enterprise $enterprise): void
    {
        //
    }

    /**
     * Handle the Enterprise "deleted" event.
     */
    public function deleted(Enterprise $enterprise): void
    {
        //
    }

    /**
     * Handle the Enterprise "restored" event.
     */
    public function restored(Enterprise $enterprise): void
    {
        //
    }

    /**
     * Handle the Enterprise "force deleted" event.
     */
    public function forceDeleted(Enterprise $enterprise): void
    {
        //
    }
}
