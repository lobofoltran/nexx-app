<?php

namespace App\Actions;

use App\Enums\OrderItemQueueStatus;
use App\Models\OrderItem;
use App\Models\OrderItemQueue;

class CreateNewOrderItemQueueAction
{
    private static string $order_item_id;

    public static function handle(?OrderItem $orderItem): OrderItemQueue
    {
        self::validate($orderItem);

        $orderItemQueue = new OrderItemQueue;
        $orderItemQueue->atcm_order_item_id = self::$order_item_id;
        $orderItemQueue->status = OrderItemQueueStatus::InQueue->value;
        $orderItemQueue->save();

        CreateNewOrderMovimentationAction::handle($orderItem->order, OrderItemQueue::class, $orderItemQueue->id, 'create', 'Abertura da Fila de Atração');

        return $orderItemQueue;
    }

    private static function validate(?OrderItem $orderItem): void
    {
        if ($orderItem) {
            if (!$orderItem->exists()) throw new \Exception(__('Produto não existe!'), 1);
            if (!$orderItem->product->productCategory->is_attraction) throw new \Exception(__('Produto não é uma atração!'), 2);

            self::$order_item_id = $orderItem->id;
        } else {
            throw new \Exception(__('Produto não existe!'), 3);
        }
    }
}
