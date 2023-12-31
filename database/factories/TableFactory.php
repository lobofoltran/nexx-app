<?php

namespace Database\Factories;

use App\Enums\TableStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Table>
 */
class TableFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'identity' => null,
            'status' => TableStatus::Available->value,
            'owner_id' => '1',
        ];
    }
}
