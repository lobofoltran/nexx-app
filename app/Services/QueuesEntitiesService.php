<?php

namespace App\Services;
use App\Models\QueuesEntities;

class QueuesEntitiesService
{
    public static function reloadAll()
    {
        $queuesEntities = QueuesEntities::where('active', true)->get();

        foreach ($queuesEntities as $queueEntity) {
            if (date('Y-m-d H:i:s') > $queueEntity->finish_at) {
                $queueEntity->active = false;
                $queueEntity->save();
                
                OrderItemQueueService::setDone($queueEntity->queue, true);
                ProductEntityService::setAvailable($queueEntity->entity, true);
            }
        }
    }
}