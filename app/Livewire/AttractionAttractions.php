<?php

namespace App\Livewire;

use App\Actions\CreateNewQueuesEntitiesAction;
use App\Enums\OrderItemQueueStatus;
use App\Enums\ProductEntityStatus;
use App\Models\OrderItemQueue;
use App\Models\ProductEntity;
use Livewire\Component;

class AttractionAttractions extends Component
{
    public $search;
    public $selectedAttraction;
    public $selectedQueue;
    public $queues = [];
    public $attractions = [];
    public $showModalAttraction = false;

    public function modalAttraction(ProductEntity $attraction)
    {
        if ($attraction->status === ProductEntityStatus::Available->value) {
            $this->selectedAttraction = $attraction;
            $this->queues = OrderItemQueue::where('status', OrderItemQueueStatus::InQueue->value)
                ->get();

            $this->showModalAttraction = !$this->showModalAttraction;
        }
    }

    public function saveQueue()
    {
        CreateNewQueuesEntitiesAction::handle(OrderItemQueue::find($this->selectedQueue), $this->selectedAttraction);

        $this->showModalAttraction = false;
        $this->selectedQueue = null;
    }

    public function render()
    {
        if ($this->search) {
            $this->attractions = ProductEntity::query()
                ->whereRelation('product', 'name', 'LIKE', '%' . $this->search . '%')
                ->orWhere('id', 'LIKE', '%' . $this->search . '%')
                ->orWhere('name', 'LIKE', '%' . $this->search . '%')
                ->get();
        } else {
            $this->attractions = ProductEntity::all();
        }

        return view('livewire.attraction-attractions');
    }
}
