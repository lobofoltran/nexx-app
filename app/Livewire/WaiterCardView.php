<?php

namespace App\Livewire;

use App\Models\Card;
use Livewire\Component;

class WaiterCardView extends Component
{
    public $card;

    public function returnPage()
    {
        return $this->redirectRoute('waiter.card');
    }

    public function redirectNewOrder()
    {
        return $this->redirectRoute('waiter.new-order', ['id'=> $this->card->id]);
    }

    public function render()
    {
        $this->card = Card::find(request('id'));

        return view('livewire.waiter-card-view');
    }
}
