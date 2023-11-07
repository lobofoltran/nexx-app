<?php

namespace Database\Factories;

use App\Enums\CardStatus;
use App\Models\Table;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Card>
 */
class CardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'atcm_table_id' => Table::factory(),
            'identity' => null,
            'status' => CardStatus::Active->value,
            'owner_id' => '1',
        ];
    }
}
