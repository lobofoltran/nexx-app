<?php

namespace Database\Seeders;

use App\Enums\CardStatus;
use App\Enums\OrderItemsStatus;
use App\Models\Card;
use App\Models\CardPhysical;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Table;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i <= 10; $i++) { 
            Table::factory([
                'identity' => 'Mesa ' . str_pad($i, 3, '0', STR_PAD_LEFT),
            ])->create();
        }

        for ($i = 0; $i <= 10; $i++) { 
            CardPhysical::factory([
                'code' => str_pad($i, 3, '0', STR_PAD_LEFT),
            ])->create();
        }

        Card::factory(['status' => CardStatus::Closed->value])->count(100)->create();

        $productCategory = ProductCategory::factory([
            'description' => 'Atrações',
            'is_attraction' => true,
        ])->create();

        Product::factory([
            'atcm_products_categories_id' => $productCategory->id,

        ])->create();

        ProductCategory::factory([
            'description' => 'Hambúrgueres',
        ])->create();

        ProductCategory::factory([
            'description' => 'Acompanhantes',
        ])->create();

        ProductCategory::factory([
            'description' => 'Acompanhantes',
        ])->create();


        // $date = now()->subMonth()->startOfMonth();

        // for ($i = 0; $i < 30; $i ++) {
        //     OrderItem::factory(['status' => OrderItemsStatus::Delivered->value, 'created_at' => $date])->count(rand(5, 30))->create();
        //     $date->addDay();
        // }

        // $date = now()->startOfMonth();

        // for ($i = 0; $i <= now()->day; $i ++) {
        //     OrderItem::factory(['status' => OrderItemsStatus::Delivered->value, 'created_at' => $date])->count(rand(10, 60))->create();
        //     $date->addDay();
        // }
    }
}
