<?php

namespace App\Actions;
use App\Models\Payment;

class UpdatePaymentAction
{
    public static function handle(Payment $payment, array $paymentData): Payment
    {
        return $payment;
    }
}
