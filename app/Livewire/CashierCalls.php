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

    public function render()
    {
        $this->calls = Call::where('done', false)->get();

        return view('livewire.cashier-calls');
    }
}
