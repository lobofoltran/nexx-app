<?php

namespace App\Observers;

use App\Models\WaitingList;

class WaitingListObserver
{
    /**
     * Handle the WaitingList "created" event.
     */
    public function created(WaitingList $waitingList): void
    {
        //
    }

    /**
     * Handle the WaitingList "updated" event.
     */
    public function updated(WaitingList $waitingList): void
    {
        //
    }

    /**
     * Handle the WaitingList "deleted" event.
     */
    public function deleted(WaitingList $waitingList): void
    {
        //
    }

    /**
     * Handle the WaitingList "restored" event.
     */
    public function restored(WaitingList $waitingList): void
    {
        //
    }

    /**
     * Handle the WaitingList "force deleted" event.
     */
    public function forceDeleted(WaitingList $waitingList): void
    {
        //
    }
}
