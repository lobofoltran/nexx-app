<?php

namespace App\Livewire;

use App\Models\Card;
use App\Models\CardPhysical;
use Livewire\Component;

class WaiterCardPhysicalView extends Component
{
    public $route;
    public $cardPhysical;
    
    public function viewCard(Card $card)
    {
        return redirect()->route('waiter.card-view', ['card' => $card->id]);
    }

    public function returnPage()
    {
        redirect($this->route);
    }

    public function mount()
    {
        $this->route = url()->previous();
        $this->cardPhysical = CardPhysical::find(request('cardPhysical'));
    }

    public function render()
    {
        return view('livewire.waiter-card-physical-view');
    }
}
