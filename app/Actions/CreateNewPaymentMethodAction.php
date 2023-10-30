<?php

namespace App\Actions;

use App\Models\PaymentMethod;

class CreateNewPaymentMethodAction
{
    public static function handle(?string $name = null, bool $active = true): PaymentMethod
    {
        self::validate($name);

        $paymentMethod = new PaymentMethod;
        $paymentMethod->name = trim($name);
        $paymentMethod->active = $active;
        $paymentMethod->save();

        CreateNewAuditLogAction::handle(PaymentMethod::class, $paymentMethod->id, 'create', 'Criado o Método de Pagamento');

        return $paymentMethod;
    }

    private static function validate(?string $name): void
    {
        if (!$name) throw new \Exception(__('Nome do método de pagamento não informado!'), 1);
    }
}
