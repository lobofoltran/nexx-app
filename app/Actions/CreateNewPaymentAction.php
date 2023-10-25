<?php

namespace App\Actions;
use App\Models\Payment;

class CreateNewPaymentAction
{
    public function handle(array $paymentData): Payment
    {
        return Payment::create([
        ]);
    }
}
