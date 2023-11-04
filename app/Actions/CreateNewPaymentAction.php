<?php

namespace App\Actions;

use App\Enums\CardStatus;
use App\Enums\PaymentStatus;
use App\Models\Card;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Services\CardService;

class CreateNewPaymentAction
{
    private static string $card_id;
    private static string $payment_method_id;
    private static string $value = '0';
    private static string $transshipment = '0';
    private static string $consummation;

    public static function handle(?Card $card, ?PaymentMethod $paymentMethod, string $value = '0'): Payment
    {
        self::validate($card, $paymentMethod, $value);

        $payment = new Payment;
        $payment->status = PaymentStatus::Concluded->value;
        $payment->atcm_card_id = self::$card_id;
        $payment->atcm_payment_method_id = self::$payment_method_id;
        $payment->value = self::$value;
        $payment->transshipment = self::$transshipment;
        $payment->save();

        CreateNewCardMovimentationAction::handle($card, Payment::class, $payment->id, 'create', 'Abertura de pagamento');

        return $payment;
    }

    private static function validate(?Card $card, ?PaymentMethod $paymentMethod, string $value): void
    {
        self::clean();

        if ($card) {
            if (!$card->exists()) {
                throw new \Exception(__('Comanda não existe!'), 1);
            }

            if ($card->status === CardStatus::Closed->value) {
                throw new \Exception(__('Comanda não ativa!'), 2);
            }
        } else {
            throw new \Exception(__('Comanda não existe!'), 1);
        }

        if ($paymentMethod) {
            if (!$paymentMethod->exists()) {
                throw new \Exception(__('Método de pagamento não existe!'), 3);
            }
        } else {
            throw new \Exception(__('Método de pagamento não existe!'), 3);
        }

        self::$card_id = $card->id;
        self::$payment_method_id = $paymentMethod->id;
        self::$value = $value;

        self::$consummation = CardService::getConsummation($card);
        $totalNew = $value + CardService::getPaid($card);

        if ($totalNew > self::$consummation) {
            self::$transshipment = $totalNew - self::$consummation;
        }
    }

    private static function clean(): void
    {
        self::$value = '0';
        self::$transshipment = '0';
    }
}
