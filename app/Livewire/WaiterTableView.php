<?php

namespace App\Livewire;

use App\Actions\CreateNewCardAction;
use App\Actions\CreateNewGroupTableAction;
use App\Actions\DeleteGroupCardAction;
use App\Actions\DeleteGroupTableAction;
use App\Enums\CardPhysicalStatus;
use App\Models\Card;
use App\Models\CardPhysical;
use App\Models\GroupTable;
use App\Models\Table;
use App\Services\TableService;
use Livewire\Component;

class WaiterTableView extends Component
{
    public $route;
    public $table;
    public $tables;
    public $atcm_table_id;
    public $confirmingGroupTables = false;
    public $tableNull = false;
    public $confirmingAddCard = false;
    public $identity;
    public $atcm_card_physical_id;
    public $cardsPhysical;

    public function confirmAddCard(): void
    {
        $this->confirmingAddCard = !$this->confirmingAddCard;
    }

    public function createCard(): void
    {
        CreateNewCardAction::handle($this->table, $this->identity, CardPhysical::find($this->atcm_card_physical_id));

        $this->identity = '';
        $this->atcm_card_physical_id = '';
        $this->confirmingAddCard = false;

        $this->table->refresh();
    }

    public function viewTable(Table $table)
    {
        if (request()->routeIs('waiter.*')) {
            return redirect()->route('waiter.table-view', ['table' => $table->id]);
        } else {
            return redirect()->route('cashier.table-view', ['table' => $table->id]);
        }
    }

    public function removeGropment(GroupTable $groupTable)
    {
        DeleteGroupTableAction::handle($groupTable);
    }

    public function confirmGroupTables()
    {
        $this->tables = Table::where('id', '!=', $this->table->id)
        ->whereNotIn('id', $this->table->groupments->pluck('id'))
        ->get();
        $this->confirmingGroupTables = !$this->confirmingGroupTables;
    }

    public function setTableNullFalse()
    {
        $this->tableNull = false;
    }

    public function groupTable()
    {
        if (!$this->atcm_table_id) {
            $this->tableNull = true;
            return;
        }

        CreateNewGroupTableAction::handle($this->table, Table::find($this->atcm_table_id));
        $this->confirmingGroupTables = false;
        $this->atcm_table_id = null;
    }

    public function setAvalible()
    {
        TableService::setAvailable($this->table);
    }

    public function returnPage()
    {
        redirect($this->route);
    }

    public function viewCard(Card $card)
    {
        if (request()->routeIs('waiter.*')) {
            return redirect()->route('waiter.card-view', ['card' => $card->id]);
        } else {
            return redirect()->route('cashier.card-view', ['card' => $card->id]);
        }
    }

    public function mount()
    {
        $this->route = '/waiter/tables';
        $this->table = Table::find(request('table'));
        $this->cardsPhysical = CardPhysical::where('status', CardPhysicalStatus::Available->value)->get();
    }

    public function render()
    {
        return view('livewire.waiter-table-view');
    }
}
