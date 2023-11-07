<?php

namespace Database\Factories;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'atcm_products_categories_id' => ProductCategory::factory(),
            'name' => $this->faker->title(),
            'description' => $this->faker->jobTitle(),
            'active' => true,
            'time' => '0',
            'show_to_bar' => false,
            'show_to_kitchen' => false,
            'show_to_cashier' => false,
            'image_url' => null,
            'value' => rand(0, 200),
            'cost' => rand(0, 150),
            'owner_id' => '1',
        ];
    }
}
