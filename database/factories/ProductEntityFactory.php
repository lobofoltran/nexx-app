<?php

namespace Database\Factories;

use App\Enums\ProductEntityStatus;
use App\Models\Product;
use App\Models\ProductEntity;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductEntity>
 */
class ProductEntityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'atcm_product_id' => Product::factory(),
            'name' => $this->faker()->name(),
            'active' => true,
            'status' => ProductEntityStatus::Available->value,
            'owner_id' => '1',
        ];
    }
}
