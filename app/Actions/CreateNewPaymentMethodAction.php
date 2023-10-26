<?php

namespace App\Actions;
use App\Models\PaymentMethod;

class CreateNewPaymentMethodAction
{
    public static function handle(array $paymentMethodData): PaymentMethod
    {
        return PaymentMethod::create([
        ]);
    }
}
