<?php

namespace App\Observers;

use App\Models\EnterpriseUser;

class EnterpriseUserObserver
{
    /**
     * Handle the EnterpriseUser "created" event.
     */
    public function created(EnterpriseUser $enterpriseUser): void
    {
        //
    }

    /**
     * Handle the EnterpriseUser "updated" event.
     */
    public function updated(EnterpriseUser $enterpriseUser): void
    {
        //
    }

    /**
     * Handle the EnterpriseUser "deleted" event.
     */
    public function deleted(EnterpriseUser $enterpriseUser): void
    {
        //
    }

    /**
     * Handle the EnterpriseUser "restored" event.
     */
    public function restored(EnterpriseUser $enterpriseUser): void
    {
        //
    }

    /**
     * Handle the EnterpriseUser "force deleted" event.
     */
    public function forceDeleted(EnterpriseUser $enterpriseUser): void
    {
        //
    }
}
