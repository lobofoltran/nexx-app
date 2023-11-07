<?php

namespace App\Livewire;

use App\Actions\CreateNewCallAction;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class CostumerTable extends Component
{
    public $table;

    public function solicitarFechamento()
    {
        CreateNewCallAction::handle($this->table, 'Fechamento da Comanda');
    }

    public function chamarGarcom()
    {
        CreateNewCallAction::handle($this->table, 'Chamando Garçom');
    }

    public function mount()
    {
        $this->table = Session::get('costumer')['data'];
    }

    public function redirectCatalogue()
    {
        return redirect()->route('costumer.new-order');
    }

    public function render()
    {
        return view('livewire.costumer-table');
    }
}
