<?php

namespace App\Livewire;

use App\Actions\CreateNewGroupCardAction;
use App\Actions\CreateNewGroupTableAction;
use App\Actions\DeleteGroupCardAction;
use App\Actions\UpdateCardAction;
use App\Enums\CardPhysicalStatus;
use App\Enums\CardStatus;
use App\Enums\TableStatus;
use App\Models\Card;
use App\Models\CardPhysical;
use App\Models\GroupCard;
use App\Models\Table;
use Livewire\Component;

class WaiterCardView extends Component
{
    public $route;
    public $card;
    public $tables;
    public $identity;
    public $atcm_table_id;
    public $confirmingEditIdentity = false;
    public $confirmingEditTable = false;
    public $confirmingEditCardPhysical = false;
    public $newCardPhysical;

    public function confirmEditCardPhysical()
    {
        $this->confirmingEditCardPhysical = !$this->confirmingEditCardPhysical;
    }

    public function editCardPhysical()
    {
        UpdateCardAction::handle($this->card, $this->card->identity, $this->card->table, CardPhysical::find($this->newCardPhysical));

        $this->confirmingEditCardPhysical = false;
        $this->card->refresh();
    }

    public function viewCardPhysical()
    {
        if (request()->routeIs('waiter.*')) {
            return redirect()->route('waiter.cards-physical-view', ['cardPhysical' => $this->card->cardPhysical->id]);
        } else {
            return redirect()->route('cashier.cards-physical-view', ['cardPhysical' => $this->card->cardPhysical->id]);
        }
    }

    public function viewTable()
    {
        if ($this->card->table) {
            if (request()->routeIs('waiter.*')) {
                return redirect()->route('waiter.table-view', ['table' => $this->card->table->id]);
            } else {
                return redirect()->route('cashier.table-view', ['table' => $this->card->table->id]);
            }
        }
    }

    public function confirmEditIdentity(): void
    {
        $this->confirmingEditIdentity = !$this->confirmingEditIdentity;
    }

    public $confirmingGroupCards = false;
    public $cards;

    public function confirmGroupCards()
    {
        $this->confirmingGroupCards = !$this->confirmingGroupCards;
    }

    public $cardNull = false;

    public function setCardNullFalse()
    {
        $this->cardNull = false;
    }

    public $tableNull = false;

    public function setTableNullFalse()
    {
        $this->tableNull = false;
    }

    public $atcm_card_id;

    public function groupTable()
    {
        if (!$this->atcm_table_id) {
            $this->tableNull = true;
            return;
        }

        CreateNewGroupTableAction::handle($this->card->table, Table::find($this->atcm_table_id));
        $this->confirmingGroupTables = false;
        $this->atcm_table_id = null;
    }

    public function groupCard()
    {
        if (!$this->atcm_card_id) {
            $this->cardNull = true;
            return;
        }

        CreateNewGroupCardAction::handle($this->card, Card::find($this->atcm_card_id));
        $this->confirmingGroupCards = false;
        $this->atcm_card_id = null;
    }

    public function viewCard(Card $card)
    {
        if (request()->routeIs('waiter.*')) {
            return redirect()->route('waiter.card-view', ['card' => $card->id]);
        } else {
            return redirect()->route('cashier.card-view', ['card' => $card->id]);
        }
    }

    public function printCard()
    {
        if (request()->routeIs('waiter.*')) {
            return redirect()->route('waiter.card-view.print', ['card' => $this->card]);
        } else {
            return redirect()->route('cashier.card-view.print', ['card' => $this->card]);
        }
    }

    public $confirmingGroupTables = false;

    public function confirmGroupTables()
    {
        $this->confirmingGroupTables = !$this->confirmingGroupTables;
    }

    public function removeGropment(GroupCard $groupCard)
    {
        DeleteGroupCardAction::handle($groupCard);
    }

    public function editIdentity(): void
    {
        UpdateCardAction::handle($this->card, $this->identity, $this->card->table, $this->card->cardPhysical);

        $this->confirmingEditIdentity = false;
        $this->card->refresh();
    }

    public function confirmEditTable(): void
    {
        $this->confirmingEditTable = !$this->confirmingEditTable;
    }

    public function editTable(): void
    {
        UpdateCardAction::handle($this->card, $this->card->identity, Table::find($this->atcm_table_id), $this->card->cardPhysical);
        
        $this->confirmingEditTable = false;
        $this->card->refresh();
    }

    public function returnPage()
    {
        redirect($this->route);
    }

    public function redirectNewOrder()
    {
        if (request()->routeIs('waiter.*')) {
            return redirect()->route('waiter.new-order', ['card' => $this->card->id]);
        } else {
            return redirect()->route('cashier.new-order', ['card' => $this->card->id]);
        }
    }

    public function redirectPayment()
    {
        if (request()->routeIs('waiter.*')) {
            return redirect()->route('waiter.payment', ['card' => $this->card->id]);
        } else {
            return redirect()->route('cashier.payment', ['card' => $this->card->id]);
        }
    }

    public $cardsPhysical;

    public function mount()
    {
        $this->route = url()->previous();
        $this->card = Card::find(request('card'));
        $this->identity = $this->card->identity;
        $this->atcm_table_id = $this->card->table ? $this->card->table->id : null;
        $this->tables = Table::whereIn('status', [TableStatus::Available->value, TableStatus::InUse->value, TableStatus::Grouped->value, TableStatus::WaitingCleaning->value])->get();
        $this->cardsPhysical = CardPhysical::where('status', CardPhysicalStatus::Available->value)->get();
        $this->cards = Card::where('status', CardStatus::Active->value)->get();
        $this->cardsPhysical = CardPhysical::where('status', CardPhysicalStatus::Available->value)->get();
    }

    public function render()
    {
        return view('livewire.waiter-card-view');
    }
}
