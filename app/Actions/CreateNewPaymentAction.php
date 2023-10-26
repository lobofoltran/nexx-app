<?php

namespace App\Actions;
use App\Models\Payment;

class CreateNewPaymentAction
{
    public static function handle(array $paymentData): Payment
    {
        return Payment::create([
        ]);
    }
}
