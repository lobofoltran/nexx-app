<?php

namespace App\Livewire;

use App\Actions\CreateNewCardAction;
use App\Enums\CardPhysicalStatus;
use App\Enums\CardStatus;
use App\Enums\TableStatus;
use App\Models\Card;
use App\Models\CardPhysical;
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
    public $atcm_card_physical_id = '';
    public $cardsPhysical;

    public function confirmAddCard(): void
    {
        $this->confirmingAddCard = !$this->confirmingAddCard;
    }

    public function createCard(): void
    {
        CreateNewCardAction::handle(Table::find($this->atcm_table_id), $this->identity, CardPhysical::find($this->atcm_card_physical_id));

        $this->atcm_table_id = '';
        $this->identity = '';
        $this->atcm_card_physical_id = '';
        $this->confirmingAddCard = false;

        $this->render();
    }

    public function viewCard(Card $card): void
    {
        if ($this->isWaiter) {
            $this->redirectRoute('waiter.card-view', ['card' => $card->id]);
        } else {
            $this->redirectRoute('cashier.card-view', ['card' => $card->id]);
        }
    }

    public $isWaiter = true;

    public function render()
    {
        $this->isWaiter = request()->routeIs('waiter.*');
        $this->tables = Table::whereIn('status', [TableStatus::Available->value, TableStatus::InUse->value, TableStatus::Grouped->value, TableStatus::WaitingCleaning->value])->get();
        $this->cardsPhysical = CardPhysical::where('status', CardPhysicalStatus::Available->value)->get();

        if ($this->search) {
            $this->cards = Card::where('id', 'LIKE', '%'. $this->search . '%')->orWhere('identity', 'LIKE', '%'. $this->search . '%')->get();
        } else {
            $this->cards = Card::where('status', '!=', CardStatus::Closed->value)->get();
        }

        return view('livewire.waiter-card');
    }
}
