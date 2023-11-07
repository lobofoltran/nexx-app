<?php

namespace App\Actions;

use App\Enums\OrderItemsStatus;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class CreateNewOrderItemAction
{
    private static string $order_id;
    private static string $product_id;
    private static string $value;
    private static string $cost;

    public static function handle(?Order $order, ?Product $product, ?string $observations = null): OrderItem
    {
        self::validate($order, $product);
        
        $orderItem = new OrderItem;
        $orderItem->atcm_order_id = self::$order_id;
        $orderItem->atcm_product_id = self::$product_id;
        $orderItem->observations = trim($observations);
        $orderItem->value = self::$value;
        $orderItem->cost = self::$cost;
        $orderItem->status = OrderItemsStatus::Assessing->value;
        $orderItem->save();

        CreateNewOrderMovimentationAction::handle($order, OrderItem::class, $orderItem->id, 'create', 'Abertura do Item de Pedido');

        if ($orderItem->product->productCategory->is_attraction) {
            CreateNewOrderItemQueueAction::handle($orderItem);
        }

        return $orderItem;
    }

    private static function validate(?Order $order, ?Product $product): void
    {
        if ($order) {
            if (!$order->exists()) throw new \Exception(__('Pedido não existe!'), 1);
        } else {
            throw new \Exception(__('Pedido não existe!'), 2);
        }

        self::$order_id = $order->id;

        if ($product) {
            if (!$product->exists()) throw new \Exception(__('Comanda não existe!'), 3);
        } else {
            throw new \Exception(__('Comanda não existe!'), 4);
        }

        self::$product_id = $product->id;
        self::$value = $product->value;
        self::$cost = $product->cost;
    }
}
