<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\Card;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'atcm_card_id' => Card::factory(),
            'status' => OrderStatus::Preparing->value,
            'owner_id' => '1',
        ];
    }
}
