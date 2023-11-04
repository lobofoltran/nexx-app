<?php

namespace App\Actions;

use App\Enums\CardStatus;
use App\Enums\OrderStatus;
use App\Models\Card;
use App\Models\Order;

class CreateNewOrderAction
{
    private static string $card_id;

    public static function handle(?Card $card, array $items = []): Order
    {
        self::validate($card, $items);

        $order = new Order;
        $order->atcm_card_id = self::$card_id;
        $order->status = OrderStatus::Preparing->value;
        $order->save();

        foreach ($items as $product) {
            CreateNewOrderItemAction::handle($order, $product);
        }

        CreateNewCardMovimentationAction::handle($card, Order::class, $order->id, 'create', 'Abertura de pedido');
        CreateNewOrderMovimentationAction::handle($order, Order::class, $order->id, 'create', 'Abertura de pedido');

        return $order;
    }

    private static function validate(?Card $card, array $items): void
    {
        if ($card) {
            if (!$card->exists()) throw new \Exception(__('Comanda não existe!'), 1);
            if ($card->status === CardStatus::Closed->value) throw new \Exception(__('Comanda não ativa!'), 2);
        } else {
            throw new \Exception(__('Comanda não existe!'), 1);
        }

        self::$card_id = $card->id;

        if (sizeof($items) <= 0) throw new \Exception(__('Nenhum item no pedido!'), 1);

        foreach ($items as $product) {
            if (!$product) {
                throw new \Exception(__('Produto não especificado nos itens do pedido!'), 1);
            } else {
                if (!$product->exists()) throw new \Exception(__('Produto do item do produto não existe!'), 1);
            }
        }
    }
}
