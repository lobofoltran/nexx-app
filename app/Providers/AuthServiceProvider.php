<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Enums\RolesEnum;
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
use App\Policies\CardPolicy;
use App\Policies\OrderItemPolicy;
use App\Policies\OrderItemQueuePolicy;
use App\Policies\OrderPolicy;
use App\Policies\PaymentMethodPolicy;
use App\Policies\PaymentPolicy;
use App\Policies\ProductCategoryPolicy;
use App\Policies\ProductEntityPolicy;
use App\Policies\ProductPolicy;
use App\Policies\TablePolicy;
use App\Policies\WaitingListPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Card::class            => CardPolicy::class,
        Table::class           => TablePolicy::class,
        ProductCategory::class => ProductCategoryPolicy::class,
        Product::class         => ProductPolicy::class,
        ProductEntity::class   => ProductEntityPolicy::class,
        Order::class           => OrderPolicy::class,
        OrderItem::class       => OrderItemPolicy::class,
        OrderItemQueue::class  => OrderItemQueuePolicy::class,
        PaymentMethod::class   => PaymentMethodPolicy::class,
        Payment::class         => PaymentPolicy::class,
        WaitingList::class     => WaitingListPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            return $user->hasRole(RolesEnum::ADMIN->value) ? true : null;
        });
    }
}
