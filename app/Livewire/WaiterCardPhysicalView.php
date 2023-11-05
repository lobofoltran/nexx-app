<?php

namespace App\Livewire;

use App\Actions\CreateNewCardAction;
use App\Enums\TableStatus;
use App\Models\Card;
use App\Models\CardPhysical;
use App\Models\Table;
use Livewire\Component;

class WaiterCardPhysicalView extends Component
{
    public $route;
    public $cardPhysical;
    public $tables;
    public $identity;
    public $atcm_table_id;
    public $confirmingAddCard;

    public function confirmAddCard(): void
    {
        $this->confirmingAddCard = !$this->confirmingAddCard;
    }

    public function createCard(): void
    {
        CreateNewCardAction::handle(Table::find($this->atcm_table_id), $this->identity, $this->cardPhysical);

        $this->identity = '';
        $this->atcm_table_id = '';
        $this->confirmingAddCard = false;

        $this->cardPhysical->refresh();
    }

    public function viewCard(Card $card)
    {
        if (request()->routeIs('waiter.*')) {
            return redirect()->route('waiter.card-view', ['card' => $card->id]);
        } else {
            return redirect()->route('cashier.card-view', ['card' => $card->id]);
        }
    }

    public function returnPage()
    {
        redirect($this->route);
    }

    public function mount()
    {
        $this->route = url()->previous();
        $this->cardPhysical = CardPhysical::find(request('cardPhysical'));
        $this->tables = Table::whereIn('status', [TableStatus::Available->value, TableStatus::InUse->value, TableStatus::Grouped->value, TableStatus::WaitingCleaning->value])->get();
    }

    public function render()
    {
        return view('livewire.waiter-card-physical-view');
    }
}
