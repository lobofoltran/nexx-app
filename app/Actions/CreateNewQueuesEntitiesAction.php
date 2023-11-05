<?php

namespace App\Actions;

use App\Models\OrderItemQueue;
use App\Models\ProductEntity;
use App\Models\QueuesEntities;
use App\Services\OrderItemQueueService;
use App\Services\ProductEntityService;
use Illuminate\Support\Carbon;

class CreateNewQueuesEntitiesAction
{
    private static string $orderItemQueue_id;
    private static string $productEntity_id;

    public static function handle(?OrderItemQueue $orderItemQueue = null, ?ProductEntity $productEntity = null): QueuesEntities
    {
        self::validate($orderItemQueue, $productEntity);

        $queuesEntities = new QueuesEntities;
        $queuesEntities->atcm_order_item_queues_id = self::$orderItemQueue_id;
        $queuesEntities->atcm_product_entities_id = self::$productEntity_id;
        $queuesEntities->finish_at = Carbon::now()->addMinutes($orderItemQueue->orderItem->product->time);
        $queuesEntities->active = true;
        $queuesEntities->save();

        CreateNewCardMovimentationAction::handle($orderItemQueue->orderItem->order->card, QueuesEntities::class, $queuesEntities->id, 'update', 'Entrada na atração "' . $productEntity->name . '"');

        OrderItemQueueService::setPlaying($orderItemQueue);
        ProductEntityService::setInUse($productEntity);

        return $queuesEntities;
    }

    private static function validate(?OrderItemQueue $orderItemQueue, ?ProductEntity $productEntity): void
    {
        if ($orderItemQueue) {
            if (!$orderItemQueue->exists()) throw new \Exception(__('Fila não existe!'), 1);

            self::$orderItemQueue_id = $orderItemQueue->id;
        } else {
            throw new \Exception(__('Fila não existe!'), 2);
        }

        if ($productEntity) {
            if (!$productEntity->exists()) throw new \Exception(__('Atração não existe!'), 3);

            self::$productEntity_id = $productEntity->id;
        } else {
            throw new \Exception(__('Atração não existe!'), 4);
        }
    }

    public static function clean(): void
    {
        self::$orderItemQueue_id = null;
        self::$productEntity_id = null;
    }
}
