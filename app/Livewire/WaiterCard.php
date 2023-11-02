<?php

namespace App\Livewire;

use App\Actions\CreateNewCardAction;
use App\Enums\CardStatus;
use App\Models\Card;
use App\Models\Table;
use Livewire\Component;

class WaiterCard extends Component
{
    public $cards;
    public $tables;
    public $search = '';
    public $confirmingAddCard = false;
    public $atcm_table_id = '';
    public $identity = '';

    public function confirmAddCard(): void
    {
        $this->confirmingAddCard = !$this->confirmingAddCard;
    }

    public function createCard(): void
    {
        CreateNewCardAction::handle(Table::find($this->atcm_table_id), $this->identity);

        $this->atcm_table_id = '';
        $this->identity = '';

        $this->confirmingAddCard = false;

        $this->render();
    }

    public function viewCard(Card $card): void
    {
        $this->redirectRoute('waiter.card-view', ['id'=> $card->id]);
    }

    public function render()
    {
        $this->tables = Table::all();

        if ($this->search) {
            $this->cards = Card::search($this->search)->where('status', CardStatus::Active->value)->get();
        } else {
            $this->cards = Card::where('status', CardStatus::Active->value)->get();
        }

        return view('livewire.waiter-card');
    }
}
