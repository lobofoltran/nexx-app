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
    public static function removeGroupment(Card $card, Card $toCard): array
    {
        if (sizeof($card->groupments) <= 0) {
            $card->status = CardStatus::Active->value;
            $card->save();    
        }

        if (sizeof($toCard->groupments) <= 0) {
            $toCard->status = CardStatus::Active->value;
            $toCard->save();    
        }

        return [$card, $toCard];
    }
    
    public static function setGrouped(Card $card, Card $toCard): array
    {
        $card->status = CardStatus::Grouped->value;
        $card->save();

        CreateNewCardMovimentationAction::handle($card, Card::class, $card->id, 'update', 'Status da comanda alterado para "Agrupada"');

        $toCard->status = CardStatus::Grouped->value;
        $toCard->save();

        CreateNewCardMovimentationAction::handle($toCard, Card::class, $toCard->id, 'update', 'Status da comanda alterado para "Agrupada"');

        return [$card, $toCard];
    }

    public static function setClosed(Card $card): Card
    {
        if (self::getConsummation($card, true) <= self::getPaid($card, true)) {
            $card->status = CardStatus::Closed->value;
            $card->save();

            CreateNewCardMovimentationAction::handle($card, Card::class, $card->id, 'update', 'Status da comanda alterado para "Fechada"');

            $table = $card->table;
            
            if ($table instanceof Table) {
                TableService::setWaitingCleaning($table);
            }

            foreach ($card->groupments as $groupment) {
                $card = $groupment->card;
                $card->status = CardStatus::Closed->value;
                $card->save();
    
                CreateNewCardMovimentationAction::handle($card, Card::class, $card->id, 'update', 'Status da comanda alterado para "Fechada"');
    
                $table = $card->table;
                
                if ($table instanceof Table) {
                    TableService::setWaitingCleaning($table);
                }
            }
        }

        return $card;
    }

    public static function getConsummation(Card $card, bool $group = false): string
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

        if ($group) {
            foreach ($card->groupments as $group) {
                foreach ($group->card->orders as $order) {
                    foreach ($order->orderItems as $orderItem) {
                        if (!in_array($orderItem->status, $arrayStatusOrderItemsToNotCashIn)) {
                            $value += $orderItem->value;
                        }
                    }
                }
            }
        }

        return $value;
    }

    public static function getPaid(Card $card, bool $group = false): string
    {
        $payments = 0;

        $card->refresh();

        foreach ($card->payments->where('status', PaymentStatus::Concluded->value) as $payment) {
            $payments += $payment->value;
        }

        if ($group) {
            foreach ($card->groupments as $group) {
                foreach ($group->card->payments->where('status', PaymentStatus::Concluded->value) as $payment) {
                    $payments += $payment->value;
                }        
            }
        }

        return $payments;
    }

    public static function getTransshipment(Card $card, bool $group = false): string
    {
        $transshipments = 0;

        $card->refresh();

        foreach ($card->payments->where('status', PaymentStatus::Concluded->value) as $payment) {
            $transshipments = $payment->transshipment;
        }

        if ($group) {
            foreach ($card->groupments as $group) {
                foreach ($group->card->payments->where('status', PaymentStatus::Concluded->value) as $payment) {
                    $transshipments = $payment->transshipment;
                }        
            }
        }

        return $transshipments;
    }

    public static function getMissing(Card $card, bool $group = false): string
    {
        $missing = 0;

        $card->refresh();

        $consummation = self::getConsummation($card, $group);
        $paid = self::getPaid($card, $group);
        $transshipment = self::getTransshipment($card, $group);

        $missing = $consummation - $paid + $transshipment;


        return $missing;
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