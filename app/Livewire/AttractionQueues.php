<?php

namespace App\Livewire;

use App\Actions\CreateNewQueuesEntitiesAction;
use App\Enums\OrderItemQueueStatus;
use App\Enums\ProductEntityStatus;
use App\Models\OrderItemQueue;
use App\Models\ProductEntity;
use Livewire\Component;

class AttractionQueues extends Component
{
    public $search;
    public $queues = [];
    public $selectedAttraction;
    public $showModalQueue = false;
    public $selectedQueue = null;
    public $attractions = [];

    public function modalQueue(OrderItemQueue $queue)
    {
        if ($queue->status === OrderItemQueueStatus::InQueue->value) {
            $this->selectedQueue = $queue;
            $this->attractions = ProductEntity::where('status', ProductEntityStatus::Available->value)->get();

            $this->showModalQueue = !$this->showModalQueue;
        }
    }

    public function saveQueue()
    {
        CreateNewQueuesEntitiesAction::handle($this->selectedQueue, ProductEntity::find($this->selectedAttraction));

        $this->showModalQueue = false;
        $this->selectedQueue = null;
    }

    public function render()
    {
        if ($this->search) {
            $this->queues = OrderItemQueue::where('id', 'LIKE', '%' . $this->search . '%')->get();
        } else {
            $this->queues = OrderItemQueue::whereIn('status', [OrderItemQueueStatus::InQueue->value, OrderItemQueueStatus::Playing->value])->get();
        }

        return view('livewire.attraction-queues');
    }
}
