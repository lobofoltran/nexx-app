<?php

namespace App\Observers;

use App\Models\PaymentMethod;

class PaymentMethodObserver
{
    /**
     * Handle the PaymentMethod "created" event.
     */
    public function created(PaymentMethod $paymentMethod): void
    {
        //
    }

    /**
     * Handle the PaymentMethod "updated" event.
     */
    public function updated(PaymentMethod $paymentMethod): void
    {
        //
    }

    /**
     * Handle the PaymentMethod "deleted" event.
     */
    public function deleted(PaymentMethod $paymentMethod): void
    {
        //
    }

    /**
     * Handle the PaymentMethod "restored" event.
     */
    public function restored(PaymentMethod $paymentMethod): void
    {
        //
    }

    /**
     * Handle the PaymentMethod "force deleted" event.
     */
    public function forceDeleted(PaymentMethod $paymentMethod): void
    {
        //
    }
}
