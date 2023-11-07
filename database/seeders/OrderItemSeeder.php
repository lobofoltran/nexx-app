<?php

namespace Database\Seeders;

use App\Enums\OrderItemsStatus;
use App\Models\OrderItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $date = now()->subMonth()->startOfMonth();

        for ($i = 0; $i < 30; $i ++) {
            OrderItem::factory(['status' => OrderItemsStatus::Delivered->value, 'created_at' => $date])->count(rand(5, 30))->create();
            $date->addDay();
        }

        $date = now()->startOfMonth();

        for ($i = 0; $i <= now()->day; $i ++) {
            OrderItem::factory(['status' => OrderItemsStatus::Delivered->value, 'created_at' => $date])->count(rand(10, 60))->create();
            $date->addDay();
        }
    }
}
