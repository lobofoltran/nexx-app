<?php

namespace App\Livewire;

use App\Actions\CreateNewGroupTableAction;
use App\Actions\DeleteGroupCardAction;
use App\Actions\DeleteGroupTableAction;
use App\Models\Card;
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

    public function viewTable(Table $table)
    {
        $this->redirectRoute('waiter.table-view', ['table' => $table->id]);
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
        $this->redirectRoute('waiter.card-view', ['card' => $card->id]);
    }

    public function mount()
    {
        $this->route = '/waiter/tables';
        $this->table = Table::find(request('table'));
    }

    public function render()
    {
        return view('livewire.waiter-table-view');
    }
}
