<?php

namespace App\Providers;

use App\Models\Card;
use App\Models\CardPhysical;
use App\Models\GroupCard;
use App\Models\GroupTable;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemQueue;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductEntity;
use App\Models\Table;
use App\Models\WaitingList;
use App\Observers\CardObserver;
use App\Observers\OrderItemObserver;
use App\Observers\OrderItemQueueObserver;
use App\Observers\OrderObserver;
use App\Observers\OwnerObserver;
use App\Observers\PaymentMethodObserver;
use App\Observers\PaymentObserver;
use App\Observers\ProductCategoryObserver;
use App\Observers\ProductEntityObserver;
use App\Observers\ProductObserver;
use App\Observers\TableObserver;
use App\Observers\WaitingListObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * The model observers for your application.
     *
     * @var array
     */
    protected $observers = [
        Card::class            => [OwnerObserver::class, CardObserver::class],
        Table::class           => [OwnerObserver::class, TableObserver::class],
        ProductCategory::class => [OwnerObserver::class, ProductCategoryObserver::class],
        Product::class         => [OwnerObserver::class, ProductObserver::class],
        ProductEntity::class   => [OwnerObserver::class, ProductEntityObserver::class],
        Order::class           => [OwnerObserver::class, OrderObserver::class],
        OrderItem::class       => [OwnerObserver::class, OrderItemObserver::class],
        OrderItemQueue::class  => [OwnerObserver::class, OrderItemQueueObserver::class],
        PaymentMethod::class   => [OwnerObserver::class, PaymentMethodObserver::class],
        Payment::class         => [OwnerObserver::class, PaymentObserver::class],
        WaitingList::class     => [OwnerObserver::class, WaitingListObserver::class],
        CardPhysical::class    => [OwnerObserver::class],
        GroupCard::class       => [OwnerObserver::class],
        GroupTable::class      => [OwnerObserver::class],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
