<?php

namespace Database\Seeders;

use App\Enums\OrderItemsStatus;
use App\Enums\OrderStatus;
use App\Models\Card;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $date = now()->subMonth()->startOfMonth();

        for ($i = 0; $i < 30; $i ++) {
            for ($y = 0; $y <= rand(4, 8); $y++) { 
                $order = Order::factory()->create([
                    'atcm_card_id' => Card::find(rand(1, 100)),
                    'status' => OrderStatus::Concluded->value,
                ]);

                for ($z = 0; $z <= rand(2, 4); $z++) { 
                    $product = Product::find(rand(1, 16));

                    OrderItem::factory()->create([
                        'atcm_order_id'   => $order->id,
                        'atcm_product_id' => $product->id,
                        'value'           => $product->value,
                        'cost'            => $product->cost,    
                        'status'          => OrderItemsStatus::Delivered->value, 
                        'created_at'      => $date
                    ]);
                }
            }

            $date->addDay();
        }

        $date = now()->startOfMonth();

        for ($i = 0; $i < now()->day; $i++) {
            for ($y = 0; $y <= rand(6, 12); $y++) { 
                $order = Order::factory()->create([
                    'atcm_card_id' => Card::find(rand(1, 100)),
                    'status' => OrderStatus::Concluded->value,
                ]);

                for ($z = 0; $z <= rand(3, 6); $z++) { 
                    $product = Product::find(rand(1, 16));

                    OrderItem::factory()->create([
                        'atcm_order_id'   => $order->id,
                        'atcm_product_id' => $product->id,
                        'value'           => $product->value,
                        'cost'            => $product->cost,
                        'status'          => OrderItemsStatus::Delivered->value, 
                        'created_at'      => $date
                    ]);
                }
            }
            
            $date->addDay();
        }
    }
}
