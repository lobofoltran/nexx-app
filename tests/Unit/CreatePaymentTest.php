<?php

namespace Tests\Unit;

use App\Actions\CreateNewCardAction;
use App\Actions\CreateNewOrderAction;
use App\Actions\CreateNewPaymentAction;
use App\Actions\CreateNewPaymentMethodAction;
use App\Actions\CreateNewProductAction;
use App\Actions\CreateNewProductCategoryAction;
use App\Enums\CardStatus;
use App\Services\OrderItemService;
use App\Services\PaymentService;
use Tests\TestCase;

class CreatePaymentTest extends TestCase
{
    public function test_payment_can_created(): void
    {
        $card = CreateNewCardAction::handle();

        $productCategory = CreateNewProductCategoryAction::handle('Descrição teste');
    
        CreateNewOrderAction::handle($card, [
            CreateNewProductAction::handle($productCategory, 'Produto teste', value: '50'),
            CreateNewProductAction::handle($productCategory, 'Produto teste 2', value: '25')
        ]);

        $paymentMethod = CreateNewPaymentMethodAction::handle('Pix');

        $payment = CreateNewPaymentAction::handle($card, $paymentMethod, '50');

        $card->refresh();

        $this->assertTrue($payment->exists());
        $this->assertTrue($card->status === CardStatus::Active->value);
    }

    public function test_payment_transshipment(): void
    {
        $consumProd = 50;
        $consumAttr = 50;

        $paid = 150;
        $transship = $paid - $consumProd - $consumAttr;

        $card = CreateNewCardAction::handle();

        CreateNewOrderAction::handle($card, [
            CreateNewProductAction::handle(CreateNewProductCategoryAction::handle('Produto', true), 'Produtos', value: $consumProd),
            CreateNewProductAction::handle(CreateNewProductCategoryAction::handle('Atrações', true), 'Atrações', value: $consumAttr),
        ]);

        $paymentMethod = CreateNewPaymentMethodAction::handle('Dinheiro');
        
        $payment = CreateNewPaymentAction::handle($card, $paymentMethod, $paid);

        PaymentService::setConcluded($payment);

        $card->refresh();

        $this->assertTrue($payment->exists());
        $this->assertEquals($payment->transshipment, $transship);
        $this->assertTrue($card->status === CardStatus::Closed->value);
    }

    public function test_payment_if_orders_canceled(): void
    {
        $consumProd = 50; // Canceled
        $consumAttr = 50;

        $paid = 150;
        $transship = $paid - $consumAttr;

        $card = CreateNewCardAction::handle();

        $order = CreateNewOrderAction::handle($card, [
            CreateNewProductAction::handle(CreateNewProductCategoryAction::handle('Produto', true), 'Produtos', value: $consumProd),
            CreateNewProductAction::handle(CreateNewProductCategoryAction::handle('Atrações', true), 'Atrações', value: $consumAttr),
        ]);

        OrderItemService::setCanceled($order->orderItems->first());

        $paymentMethod = CreateNewPaymentMethodAction::handle('Dinheiro');
        
        $payment = CreateNewPaymentAction::handle($card, $paymentMethod, $paid);
        PaymentService::setConcluded($payment);

        $card->refresh();

        $this->assertTrue($payment->exists());
        $this->assertEquals($payment->transshipment, $transship);
        $this->assertTrue($card->status === CardStatus::Closed->value);
    }

    public function test_payment_if_orders_rejected(): void
    {
        $consumProd = 50; // Rejected
        $consumAttr = 50;

        $paid = 150;
        $transship = $paid - $consumAttr;

        $card = CreateNewCardAction::handle();

        $order = CreateNewOrderAction::handle($card, [
            CreateNewProductAction::handle(CreateNewProductCategoryAction::handle('Produto', true), 'Produtos', value: $consumProd),
            CreateNewProductAction::handle(CreateNewProductCategoryAction::handle('Atrações', true), 'Atrações', value: $consumAttr),
        ]);

        OrderItemService::setRejected($order->orderItems->first());

        $paymentMethod = CreateNewPaymentMethodAction::handle('Dinheiro');
        
        $payment = CreateNewPaymentAction::handle($card, $paymentMethod, $paid);
        PaymentService::setConcluded($payment);

        $card->refresh();

        $this->assertTrue($payment->exists());
        $this->assertEquals($payment->transshipment, $transship);
        $this->assertTrue($card->status === CardStatus::Closed->value);
    }
}