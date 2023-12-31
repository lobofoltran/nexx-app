<?php

namespace App\Livewire;

use App\Models\Table;
use Livewire\Component;

class WaiterTable extends Component
{
    public $tables;
    public $search = '';
    public $isWaiter = true;

    public function viewTable(Table $table)
    {
        if ($this->isWaiter) {
            return redirect()->route('waiter.table-view', ['table' => $table->id]);
        } else {
            return redirect()->route('cashier.table-view', ['table' => $table->id]);
        }
    }

    public function mount()
    {
        $this->isWaiter = request()->routeIs('waiter.*');
    }

    public function render()
    {
        if ($this->search) {
            $this->tables = Table::where('id', 'LIKE', '%'. $this->search . '%')
                ->orWhere('identity', 'LIKE', '%'. $this->search . '%')
                ->get();
        } else {
            $this->tables = Table::all();
        }

        return view('livewire.waiter-table');
    }
}
