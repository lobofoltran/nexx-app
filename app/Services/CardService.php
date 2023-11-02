<?php

namespace App\Services;
use App\Actions\CreateNewCardMovimentationAction;
use App\Enums\CardStatus;
use App\Enums\OrderItemsStatus;
use App\Enums\PaymentStatus;
use App\Models\Card;
use App\Models\Table;
use DateTime;

class CardService
{
    public static function setClosed(Card $card): Card
    {
        if (self::getConsummation($card) === self::getPaid($card)) {
            $card->status = CardStatus::Closed->value;
            $card->save();

            CreateNewCardMovimentationAction::handle($card, Card::class, $card->id, 'update', 'Status da comanda alterado para "Fechada"');

            $table = $card->table;
            
            if ($table instanceof Table) {
                TableService::setWaitingCleaning($table);
            }

            // busca todos pagamentos abertos e finaliza
        }

        return $card;
    }

    public static function getConsummation(Card $card): string
    {
        $arrayStatusOrderItemsToNotCashIn = [OrderItemsStatus::Rejected->value, OrderItemsStatus::Canceled->value];

        $value = 0;

        foreach ($card->orders as $order) {
            foreach ($order->orderItems as $orderItem) {
                if (!in_array($orderItem->status, $arrayStatusOrderItemsToNotCashIn)) {
                    $value += $orderItem->value;
                }
            }
        }

        return $value;
    }

    public static function getPaid(Card $card): string
    {
        $payments = 0;

        $card->refresh();

        foreach ($card->payments->where('status', PaymentStatus::Concluded->value) as $payment) {
            $payments = $payment->value - $payment->transshipment;
        }

        return $payments;
    }

    public static function getTime(Card $card): string
    {
        $entrada = new DateTime($card->created_at->format('Y-m-d H:i:s'));
        $dataAtual = new DateTime();
        $diferenca = $dataAtual->diff($entrada);

        $horas = $diferenca->h + ($diferenca->days * 24);
        $minutos = $diferenca->i;
        $segundos = $diferenca->s;

        $tempoDecorrido = sprintf('%02d:%02d:%02d', $horas, $minutos, $segundos);

        return $tempoDecorrido;
    }
}