<?php

namespace App\Services;
use App\Actions\CreateNewOrderMovimentationAction;
use App\Enums\OrderItemsStatus;
use App\Models\OrderItem;

class OrderItemService
{
    public static function setPreparing(OrderItem $orderItem): OrderItem
    {
        if ($orderItem->status !== OrderItemsStatus::Assessing->value) {
            throw new \Exception(__('Status do item deve estar em avaliação!'), 1);
        }

        $orderItem->status = OrderItemsStatus::Preparing->value;
        $orderItem->save();

        CreateNewOrderMovimentationAction::handle($orderItem->order, OrderItem::class, $orderItem->id, 'update', 'Status do Item do Pedido alterado para "Preparando"');

        return $orderItem;
    }

    public static function setRejected(OrderItem $orderItem): OrderItem
    {
        if ($orderItem->status !== OrderItemsStatus::Assessing->value) {
            throw new \Exception(__('Status do item deve estar em avaliação!'), 1);
        }

        $orderItem->status = OrderItemsStatus::Rejected->value;
        $orderItem->save();

        CreateNewOrderMovimentationAction::handle($orderItem->order, OrderItem::class, $orderItem->id, 'update', 'Status do Item do Pedido alterado para "Rejeitado"');

        OrderService::setConcluded($orderItem->order);

        return $orderItem;
    }

    public static function setConcluded(OrderItem $orderItem): OrderItem
    {
        if ($orderItem->status !== OrderItemsStatus::Preparing->value) {
            throw new \Exception(__('Status do item deve estar em preparação!'), 1);
        }

        $orderItem->status = OrderItemsStatus::Concluded->value;
        $orderItem->save();

        CreateNewOrderMovimentationAction::handle($orderItem->order, OrderItem::class, $orderItem->id, 'update', 'Status do Item do Pedido alterado para "Concluído"');

        return $orderItem;
    }

    public static function setDelivered(OrderItem $orderItem): OrderItem
    {
        if (!$orderItem->product->productCategory->is_attraction && $orderItem->status !== OrderItemsStatus::Concluded->value) {
            throw new \Exception(__('Status do item deve estar concluído!'), 1);
        }

        $orderItem->status = OrderItemsStatus::Delivered->value;
        $orderItem->save();

        CreateNewOrderMovimentationAction::handle($orderItem->order, OrderItem::class, $orderItem->id, 'update', 'Status do Item do Pedido alterado para "Entregue"');

        OrderService::setConcluded($orderItem->order);

        return $orderItem;
    }

    public static function setCanceled(OrderItem $orderItem): OrderItem
    {
        $orderItem->status = OrderItemsStatus::Canceled->value;
        $orderItem->save();

        CreateNewOrderMovimentationAction::handle($orderItem->order, OrderItem::class, $orderItem->id, 'update', 'Status do Item do Pedido alterado para "Cancelado"');

        OrderService::setConcluded($orderItem->order);

        return $orderItem;
    }
}