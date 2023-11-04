<?php

namespace App\Livewire;

use App\Actions\CreateNewPaymentAction;
use App\Models\Card;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Services\CardService;
use App\Services\PaymentService;
use Livewire\Component;

class WaiterPayment extends Component
{
    public $route;
    public $card;
    public $needValue = false;
    public $needPaymentMethod = false;
    public $paymentMethods;
    public $selectedPaymentMethod = null;
    public $value = null;
    public $confirmingAddPayment = false;
    public $quantityPerson = 1;
    public $calculatorItems = [];
    public $calculatorItemsTotalValue = 0;
    public $quantityPersonCalculator = 1;
    public $confirmingCancelPaymentPayment;
    public $confirmingCancelPayment = false;
    public $confirmingCloseCard = false;

    public function confirmCloseCard()
    {
        $this->confirmingCloseCard = !$this->confirmingCloseCard;
    }

    public function closeCard()
    {
        CardService::setClosed($this->card);

        $this->confirmingCloseCard = false;
    }

    public function confirmCancelPayment(Payment $payment)
    {
        $this->confirmingCancelPaymentPayment = $payment;
        $this->confirmingCancelPayment = !$this->confirmingCancelPayment;
    }

    public function cancelPayment()
    {
        PaymentService::setCanceled($this->confirmingCancelPaymentPayment);
        
        $this->confirmingCancelPaymentPayment = null;
        $this->confirmingCancelPayment = false;
    }

    public function confirmAddPayment(): void
    {
        $this->value = null;
        $this->selectedPaymentMethod = null;

        $this->confirmingAddPayment = !$this->confirmingAddPayment;
    }

    public function addPerson()
    {
        $this->quantityPerson++;
    }

    public function removePerson()
    {
        $this->quantityPerson--;

        if ($this->quantityPerson == 0) {
            $this->quantityPerson = 1;
        }
    }

    public function addToCalculator(OrderItem $item)
    {
        $this->calculatorItems[] = ['item' => $item, 'percent' => 1, 'value' => $item->value * 1];

        $this->calculatorItemsCalculate();
    }

    public function addPercentCalculatorItem(string $key, bool $add)
    {
        $this->calculatorItems[$key]['percent'] = $add ? $this->calculatorItems[$key]['percent'] + 0.1 : $this->calculatorItems[$key]['percent'] - 0.1;

        if ($this->calculatorItems[$key]['percent'] <= 0.1) {
            $this->calculatorItems[$key]['percent'] = 0.1;
        }

        if ($this->calculatorItems[$key]['percent'] > 1) {
            $this->calculatorItems[$key]['percent'] = 1;
        }

        $this->calculatorItemsCalculate();
    }

    public function addPersonCalculator(bool $add)
    {
        if ($add) {
            $this->quantityPersonCalculator++;
        } else {
            $this->quantityPersonCalculator--;
        }

        if ($this->quantityPersonCalculator == 0) {
            $this->quantityPersonCalculator = 1;
        }
    }

    public function cleanCalculator()
    {
        $this->calculatorItems = [];
    }

    public function removeCalculatorItem(string $key)
    {
        unset( $this->calculatorItems[$key] );

        $this->calculatorItemsCalculate();
    }

    public function calculatorItemsCalculate()
    {
        $totalValue = 0;

        foreach ($this->calculatorItems as $item) {
            $totalValue += $item['item']->value * $item['percent'];
        }

        $this->calculatorItemsTotalValue = $totalValue;
    }

    public function selectPaymentMethod(PaymentMethod $paymentMethod)
    {
        $this->selectedPaymentMethod = $paymentMethod;
        $this->needPaymentMethod = false;
    }

    public function addValue(int|string $value, bool $concat = true)
    {        
        $valueOld = $concat ? (string) $this->value : (float) str_replace(',', '.', $this->value);

        $valueNew = $concat ? $valueOld . $value : floatval($valueOld) + floatval($value);

        $this->value = str_replace('.', ',', $valueNew);
        $this->needValue = false;
    }

    public function clean()
    {
        $this->value = null;
    }

    public function addPayment()
    {
        if (!$this->value || $this->value <= 0) {
            $this->needValue = true;
        }

        if (!$this->selectedPaymentMethod) {
            $this->needPaymentMethod = true;
        }

        if ($this->needValue || $this->needPaymentMethod) {
            return;
        }

        CreateNewPaymentAction::handle($this->card, $this->selectedPaymentMethod, $this->value);

        $this->value = null;
        $this->selectedPaymentMethod = null;
        $this->confirmingAddPayment = false;
    }

    public function returnPage()
    {
        redirect($this->route);
    }
    
    public function mount()
    {
        $this->route = url()->previous();
        $this->card = Card::find(request('card'));
        $this->paymentMethods = PaymentMethod::all();
    }

    public function render()
    {
        return view('livewire.waiter-payment');
    }
}
