<?php

namespace App\Livewire;

use App\Models\Call;
use App\Services\CallService;
use Livewire\Component;

class CashierCalls extends Component
{
    public $calls;

    public function setDone(Call $call)
    {
        CallService::setDone($call);
    }

    public function mount()
    {
        $this->calls = Call::where('done', false)->get();
    }

    public function render()
    {
        return view('livewire.cashier-calls');
    }
}
