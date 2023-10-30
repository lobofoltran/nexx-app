<?php

namespace Tests\Unit;

use App\Actions\CreateNewPaymentMethodAction;
use Tests\TestCase;

class CreatePaymentMethodTest extends TestCase
{
    public function test_payment_method_can_created(): void
    {
        $paymentMethod = CreateNewPaymentMethodAction::handle('Pix');

        $this->assertTrue($paymentMethod->exists());
    }
}
