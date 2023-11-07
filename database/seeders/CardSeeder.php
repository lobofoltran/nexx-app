<?php

namespace Database\Seeders;

use App\Enums\CardStatus;
use App\Models\Card;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Card::factory(['status' => CardStatus::Closed->value])->count(100)->create();
    }
}
