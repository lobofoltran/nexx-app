<?php

namespace App\Livewire;

use App\Actions\CreateNewCallAction;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class CostumerCardVirtual extends Component
{
    public $card;

    public function solicitarFechamento()
    {
        CreateNewCallAction::handle($this->card->table, 'Fechamento da Comanda');
    }

    public function chamarGarcom()
    {
        CreateNewCallAction::handle($this->card->table, 'Chamando Garçom');
    }

    public function mount()
    {        
    }

    public function render()
    {
        $this->card = Session::get('costumer')['data'];

        return view('livewire.costumer-card-virtual');
    }

    public function redirectCatalogue()
    {
        return redirect()->route('costumer.new-order');
    }
}
