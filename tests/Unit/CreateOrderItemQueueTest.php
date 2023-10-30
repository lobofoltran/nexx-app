<?php

namespace Tests\Unit;

use App\Actions\CreateNewCardAction;
use App\Actions\CreateNewOrderAction;
use App\Actions\CreateNewProductAction;
use App\Actions\CreateNewProductCategoryAction;
use App\Enums\OrderItemsStatus;
use App\Enums\OrderStatus;
use App\Services\OrderItemQueueService;
use Tests\TestCase;

class CreateOrderItemQueueTest extends TestCase
{
    public function test_order_item_queue_is_automatic_created(): void
    {
        $productCategory = CreateNewProductCategoryAction::handle('Atrações', true);
    
        $product = CreateNewProductAction::handle(productCategory: $productCategory, name: 'Atração teste', value: '50');

        $card = CreateNewCardAction::handle();
        $order = CreateNewOrderAction::handle($card, [$product]);
        $orderItemQueue = $order->orderItems->first()->orderItemQueue;

        $this->assertTrue($productCategory->exists());
        $this->assertTrue($product->exists());
        $this->assertTrue($card->exists());
        $this->assertTrue($order->exists());
        $this->assertTrue($orderItemQueue->exists());
    }

    public function test_order_item_queue_is_automatic_order_canceled(): void
    {
        $productCategory = CreateNewProductCategoryAction::handle('Atrações', true);
        $product = CreateNewProductAction::handle(productCategory: $productCategory, name: 'Atração teste', value: '50');
        $card = CreateNewCardAction::handle();
        $order = CreateNewOrderAction::handle($card, [$product]);
        $orderItemQueue = $order->orderItems->first()->orderItemQueue;

        OrderItemQueueService::setCanceled($orderItemQueue);

        $order->refresh();

        $this->assertTrue($productCategory->exists());
        $this->assertTrue($product->exists());
        $this->assertTrue($card->exists());
        $this->assertTrue($order->exists());
        $this->assertTrue($orderItemQueue->exists());
        $this->assertTrue($order->status === OrderStatus::Canceled->value);
        $this->assertTrue($order->orderItems->first()->status === OrderItemsStatus::Canceled->value);
    }

    public function test_order_item_queue_is_automatic_order_concluded(): void
    {
        $productCategory = CreateNewProductCategoryAction::handle('Atrações', true);
        $product = CreateNewProductAction::handle(productCategory: $productCategory, name: 'Atração teste', value: '50');
        $card = CreateNewCardAction::handle();
        $order = CreateNewOrderAction::handle($card, [$product]);
        $orderItemQueue = $order->orderItems->first()->orderItemQueue;

        OrderItemQueueService::setDone($orderItemQueue);

        $order->refresh();

        $this->assertTrue($productCategory->exists());
        $this->assertTrue($product->exists());
        $this->assertTrue($card->exists());
        $this->assertTrue($order->exists());
        $this->assertTrue($orderItemQueue->exists());
        $this->assertTrue($order->status === OrderStatus::Concluded->value);
        $this->assertTrue($order->orderItems->first()->status === OrderItemsStatus::Delivered->value);
    }
}
