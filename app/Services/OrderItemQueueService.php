<?php

namespace App\Services;
use App\Actions\CreateNewOrderMovimentationAction;
use App\Enums\OrderItemQueueStatus;
use App\Models\OrderItemQueue;

class OrderItemQueueService
{
    public static function setDone(OrderItemQueue $orderItemQueue): OrderItemQueue
    {
        $orderItemQueue->status = OrderItemQueueStatus::Done->value;
        $orderItemQueue->save();

        CreateNewOrderMovimentationAction::handle($orderItemQueue->orderItem->order, OrderItemQueue::class, $orderItemQueue->id, 'update', 'Status da Fila do Item do Pedido alterado para "Finalizado"');

        OrderItemService::setDelivered($orderItemQueue->orderItem);

        return $orderItemQueue;
    }

    public static function setCanceled(OrderItemQueue $orderItemQueue): OrderItemQueue
    {
        $orderItemQueue->status = OrderItemQueueStatus::Canceled->value;
        $orderItemQueue->save();

        CreateNewOrderMovimentationAction::handle($orderItemQueue->orderItem->order, OrderItemQueue::class, $orderItemQueue->id, 'update', 'Status da Fila do Item do Pedido alterado para "Cancelado"');

        OrderItemService::setCanceled($orderItemQueue->orderItem);

        return $orderItemQueue;
    }
}