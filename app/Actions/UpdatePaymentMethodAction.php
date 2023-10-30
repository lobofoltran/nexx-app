<?php

namespace App\Actions;
use App\Models\PaymentMethod;

class UpdatePaymentMethodAction
{
    private static string $textLog;

    public static function handle(PaymentMethod $paymentMethod, ?string $name = null, bool $active = true): PaymentMethod
    {
        self::validate($paymentMethod, $name, $active);

        $paymentMethod->name = trim($name);
        $paymentMethod->active = $active;
        $paymentMethod->save();

        if (self::$textLog) CreateNewAuditLogAction::handle(PaymentMethod::class, $paymentMethod->id, 'update', self::$textLog);

        return $paymentMethod;
    }

    private static function validate(PaymentMethod $paymentMethod, ?string $name = null, bool $active = true): void
    {
        self::$textLog = 'Atualizado método de pagamento:';

        if (!$name) {
            throw new \Exception(__('Nome do método de pagamento não informado!'), 1);
        }

        if ($name != $paymentMethod->name) self::$textLog .= ' Nome: (' . $name . ') -> ' . $name . ';';
        if ($active != $paymentMethod->active) self::$textLog .= ' Ativo: (' . $paymentMethod->active . ') -> ' . $active . ';';
    }
}
