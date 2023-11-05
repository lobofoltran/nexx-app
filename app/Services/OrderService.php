<?php

namespace App\Services;
use App\Actions\CreateNewCardMovimentationAction;
use App\Actions\CreateNewOrderMovimentationAction;
use App\Enums\OrderItemsStatus;
use App\Enums\OrderStatus;
use App\Models\Order;

class OrderService
{
    public static function setConcluded(Order $order, bool $schedule = false): Order
    {
        $delivereds = 0;
        $canceleds = 0;

        $orderItems = $order->orderItems;

        foreach ($orderItems as $orderItem) {
            if ($orderItem->status === OrderItemsStatus::Delivered->value) {
                $delivereds++;
            }
            
            if (in_array($orderItem->status, [OrderItemsStatus::Canceled->value, OrderItemsStatus::Rejected->value])) {
                $canceleds++;
            }
        }

        $sizeOf = sizeof($orderItems);

        if ($delivereds === $sizeOf) {
            $status = 'Concluído';
            $order->status = OrderStatus::Concluded->value;
        } else if ($canceleds === $sizeOf) {
            $status = 'Cancelado';
            $order->status = OrderStatus::Canceled->value;
        } else if ($delivereds + $canceleds === $sizeOf) {
            $status = 'Parcialmente Cancelado';
            $order->status = OrderStatus::PartialCanceled->value;
        }

        $order->save();

        if (isset($status)) {
            CreateNewCardMovimentationAction::handle($order->card, Order::class, $order->id, 'update', 'Status do pedido alterado para "' . $status . '"', $schedule);
            CreateNewOrderMovimentationAction::handle($order, Order::class, $order->id, 'update', 'Status do pedido alterado para "'. $status .'"', $schedule);
        }

        return $order;
    }
}