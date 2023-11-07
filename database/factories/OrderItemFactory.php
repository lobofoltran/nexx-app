<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'atcm_order_id' => Order::factory(),
            'atcm_product_id' => Product::factory(),
            'observations' => null,
            'value' => rand(0, 200),
            'cost' => rand(0, 150),
            'created_at' => now(),
            'owner_id' => '1',
        ];
    }
}
