<?php

namespace App\Services;
use App\Actions\CreateNewCardMovimentationAction;
use App\Enums\CardStatus;
use App\Enums\OrderItemsStatus;
use App\Enums\PaymentStatus;
use App\Models\Card;
use App\Models\Table;

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

        foreach ($card->payments->where('status', PaymentStatus::Concluded->value) as $payment) {
            $payments = $payment->value - $payment->transshipment;
        }

        return $payments;
    }
}