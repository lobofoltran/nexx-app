<?php

namespace App\Actions;
use App\Enums\CardStatus;
use App\Models\OrderItem;

class UpdateOrderItemAction
{
    public static function handle(OrderItem $orderItem, string $observations = null): OrderItem
    {
        self::validate($orderItem);

        $orderItem->observations = trim($observations);
        $orderItem->save();

        CreateNewOrderMovimentationAction::handle($orderItem->order, OrderItem::class, $orderItem->id, 'update', 'Atualizado as observações do Item para "' . $observations . '"');

        return $orderItem;
    }

    private static function validate(OrderItem $orderItem): void
    {
        if ($orderItem->order->card->status !== CardStatus::Active->value) {
            throw new \Exception(__('Comanda vinculada não ativa! Impossível alterar.'), 1);
        }
    }
}
