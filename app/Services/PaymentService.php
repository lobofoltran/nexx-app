<?php

namespace App\Services;
use App\Actions\CreateNewCardMovimentationAction;
use App\Enums\CardStatus;
use App\Enums\PaymentStatus;
use App\Models\Payment;

class PaymentService
{
    public static function setConcluded(Payment $payment): Payment
    {
        $card = $payment->card;

        if ($card->status !== CardStatus::Active->value) {
            throw new \Exception('Comanda já encerrada!', 1);
        }

        $payment->status = PaymentStatus::Concluded->value;
        $payment->save();

        CreateNewCardMovimentationAction::handle($payment->card, Payment::class, $payment->id, 'update', 'Status do pagamento alterado para "Concluído"');

        if (CardService::getPaid($card) >= CardService::getConsummation($card)) {
            CardService::setClosed($card);
        }

        return $payment;
    }

    public static function setCanceled(Payment $payment): Payment
    {
        $payment->status = PaymentStatus::Canceled;
        $payment->save();

        CreateNewCardMovimentationAction::handle($payment->card, Payment::class, $payment->id, 'update', 'Status do pagamento alterado para "Cancelado"');

        return $payment;
    }
}