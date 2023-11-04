<?php

namespace App\Livewire;

use App\Models\CardPhysical;
use Livewire\Component;

class WaiterCardPhysical extends Component
{
    public $search;
    public $cardPhysicals = [];

    public function viewCardPhysical(CardPhysical $cardPhysical)
    {
        return redirect()->route('waiter.cards-physical-view', ['cardPhysical' => $cardPhysical->id]);
    }

    public function render()
    {
        if ($this->search) {
            $this->cardPhysicals = CardPhysical::where('id', 'LIKE', '%'. $this->search . '%')->get();
        } else {
            $this->cardPhysicals = CardPhysical::all();
        }

        return view('livewire.waiter-card-physical');
    }
}
