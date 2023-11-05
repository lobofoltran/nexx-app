<?php

namespace App\Services;
use App\Actions\CreateNewOrderMovimentationAction;
use App\Enums\OrderItemQueueStatus;
use App\Models\OrderItemQueue;

class OrderItemQueueService
{
    public static function setPlaying(OrderItemQueue $orderItemQueue): OrderItemQueue 
    {
        $orderItemQueue->status = OrderItemQueueStatus::Playing->value;
        $orderItemQueue->save();

        CreateNewOrderMovimentationAction::handle($orderItemQueue->orderItem->order, OrderItemQueue::class, $orderItemQueue->id, 'update', 'Status da Fila do Item do Pedido alterado para "Jogando"');
        
        return $orderItemQueue;
    }

    public static function setDone(OrderItemQueue $orderItemQueue, bool $schedule = false): OrderItemQueue
    {
        $orderItemQueue->status = OrderItemQueueStatus::Done->value;
        $orderItemQueue->save();

        CreateNewOrderMovimentationAction::handle($orderItemQueue->orderItem->order, OrderItemQueue::class, $orderItemQueue->id, 'update', 'Status da Fila do Item do Pedido alterado para "Finalizado"', $schedule);

        OrderItemService::setDelivered($orderItemQueue->orderItem, $schedule);

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