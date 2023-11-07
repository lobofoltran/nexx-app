<?php

namespace App\Livewire;

use App\Actions\CreateNewCallAction;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class CostumerCardPhysical extends Component
{
    public $card;
    public $cardPhysical;
    
    public function solicitarFechamento()
    {
        CreateNewCallAction::handle($this->card->table, 'Fechamento da Comanda');
    }

    public function chamarGarcom()
    {
        CreateNewCallAction::handle($this->card->table, 'Chamando Garçom');
    }

    public function redirectCatalogue()
    {
        return redirect()->route('costumer.new-order');
    }

    public function mount()
    {
        $this->cardPhysical = Session::get('costumer')['data'];
        $this->card = $this->cardPhysical->currentCard()->first();
    }

    public function render()
    {
        return view('livewire.costumer-card-physical');
    }
}
