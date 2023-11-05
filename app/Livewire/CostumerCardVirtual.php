<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Session;
use Livewire\Component;

class CostumerCardVirtual extends Component
{
    public $card;

    public function mount()
    {
        $this->card = Session::get('costumer')['data'];
    }

    public function render()
    {
        return view('livewire.costumer-card-virtual');
    }

    public function redirectCatalogue()
    {
        return redirect()->route('costumer.new-order');
    }
}
