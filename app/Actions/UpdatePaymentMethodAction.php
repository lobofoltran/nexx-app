<?php

namespace App\Actions;
use App\Models\PaymentMethod;

class UpdatePaymentMethodAction
{
    public function handle(PaymentMethod $paymentMethod, array $paymentMethodData): PaymentMethod
    {
        return $paymentMethod;
    }
}
