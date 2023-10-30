<?php

namespace Tests\Unit;

use App\Actions\CreateNewCardAction;
use App\Actions\CreateNewOrderAction;
use App\Actions\CreateNewProductAction;
use App\Actions\CreateNewProductCategoryAction;
use App\Enums\OrderStatus;
use App\Models\Order;
use App\Services\OrderItemService;
use SebastianBergmann\Type\VoidType;
use Tests\TestCase;

class CreateOrderTest extends TestCase
{
    public function test_order_can_created(): void
    {
        $card = CreateNewCardAction::handle();

        $productCategory = CreateNewProductCategoryAction::handle('Descrição teste');
    
        $product = CreateNewProductAction::handle(productCategory: $productCategory, name: 'Produto teste', value: '50');
        $product2 = CreateNewProductAction::handle(productCategory: $productCategory, name: 'Produto teste 2', value: '25');

        $order = CreateNewOrderAction::handle($card, [
            $product, $product2
        ]);

        $this->assertTrue($card->exists());
        $this->assertTrue($productCategory->exists());
        $this->assertTrue($product->exists());
        $this->assertTrue($product2->exists());
        $this->assertTrue($order->exists());
    }

    public function test_order_if_delivery_all(): void
    {
        $order = $this->create_order();

        foreach ($order->orderItems as $orderItem) {
            OrderItemService::setPreparing($orderItem);
            OrderItemService::setConcluded($orderItem);
            OrderItemService::setDelivered($orderItem);
        }

        $order->refresh();

        $this->assertEquals($order->status, OrderStatus::Concluded->value);
    }

    public function test_order_if_cancel_all(): void
    {
        $order = $this->create_order();

        foreach ($order->orderItems as $orderItem) {
            OrderItemService::setCanceled($orderItem);
        }

        $order->refresh();

        $this->assertEquals($order->status, OrderStatus::Canceled->value);
    }

    public function test_order_if_cancel_partial(): void
    {
        $order = $this->create_order();

        foreach ($order->orderItems as $key => $orderItem) {
            if ($key === 0) {
                OrderItemService::setPreparing($orderItem);
                OrderItemService::setConcluded($orderItem);
                OrderItemService::setDelivered($orderItem);
            } else {
                OrderItemService::setCanceled($orderItem);
            }
        }

        $order->refresh();

        $this->assertEquals($order->status, OrderStatus::PartialCanceled->value);
    }

    private function create_order(): Order
    {
        $card = CreateNewCardAction::handle();

        $productCategory = CreateNewProductCategoryAction::handle('Descrição teste');
    
        $product = CreateNewProductAction::handle(productCategory: $productCategory, name: 'Produto teste', value: '50');
        $product2 = CreateNewProductAction::handle(productCategory: $productCategory, name: 'Produto teste 2', value: '25');

        $order = CreateNewOrderAction::handle($card, [
            $product, $product2
        ]);

        $this->assertTrue($card->exists());
        $this->assertTrue($productCategory->exists());
        $this->assertTrue($product->exists());
        $this->assertTrue($product2->exists());
        $this->assertTrue($order->exists());

        return $order;
    }
}
