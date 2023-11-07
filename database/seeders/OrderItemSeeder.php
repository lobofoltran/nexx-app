<?php

namespace Database\Seeders;

use App\Enums\CardStatus;
use App\Enums\OrderItemsStatus;
use App\Enums\OrderStatus;
use App\Models\Card;
use App\Models\CardPhysical;
use App\Models\Order;
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
            Table::factory()->create([
                'identity' => 'Mesa ' . str_pad($i, 3, '0', STR_PAD_LEFT),
            ]);
        }

        for ($i = 0; $i <= 10; $i++) { 
            CardPhysical::factory()->create([
                'code' => str_pad($i, 3, '0', STR_PAD_LEFT),
            ]);
        }

        Card::factory(['status' => CardStatus::Closed->value])->count(100)->create();

        $productCategory = ProductCategory::factory()->create([
            'description' => 'Atrações',
            'is_attraction' => true,
        ]);

        Product::factory()->create([
            'atcm_products_categories_id' => $productCategory->id,
            'name'        => 'Boliche',
            'description' => '30 minutos de boliche',
            'time'        => '30',
            'value'       => '15',
            'cost'        => '3',
        ]);

        Product::factory()->create([
            'atcm_products_categories_id' => $productCategory->id,
            'name'        => 'Karaôke',
            'description' => '5 minutos de karaôke',
            'time'        => '5',
            'value'       => '0',
            'cost'        => '0',
        ]);

        Product::factory()->create([
            'atcm_products_categories_id' => $productCategory->id,
            'name'        => 'Sinuca',
            'description' => '1 hora de sinuca',
            'time'        => '60',
            'value'       => '15',
            'cost'        => '3',
        ]);

        $productCategory = ProductCategory::factory()->create([
            'description' => 'Hambúrgueres',
        ]);

        Product::factory()->create([
            'atcm_products_categories_id' => $productCategory->id,
            'name'        => 'Angus Bacon',
            'description' => '1x Hambúguer Artesanal 250g; Bacon; Salada; Pão Brioche.',
            'value'       => '29.90',
            'cost'        => '13',
        ]);

        Product::factory()->create([
            'atcm_products_categories_id' => $productCategory->id,
            'name'        => 'Angus Duplo Bacon',
            'description' => '2x Hambúguer Artesanal 250g; Bacon; Salada; Pão Brioche.',
            'value'       => '35.90',
            'cost'        => '17',
        ]);

        Product::factory()->create([
            'atcm_products_categories_id' => $productCategory->id,
            'name'        => 'Angus Cheddar Bacon',
            'description' => '1x Hambúguer Artesanal 250g; Cheddar; Bacon; Salada; Pão Brioche.',
            'value'       => '32.90',
            'cost'        => '15',
        ]);

        $productCategory = ProductCategory::factory()->create([
            'description' => 'Porções',
        ]);

        Product::factory()->create([
            'atcm_products_categories_id' => $productCategory->id,
            'name'        => 'Batata Frita 500g',
            'description' => '500 gramas de batata frita.',
            'value'       => '15.90',
            'cost'        => '5',
        ]);

        Product::factory()->create([
            'atcm_products_categories_id' => $productCategory->id,
            'name'        => 'Batata Frita Bacon Cheddar 500g',
            'description' => '500 gramas de batata frita + bacon + cheddar.',
            'value'       => '19.90',
            'cost'        => '8',
        ]);

        Product::factory()->create([
            'atcm_products_categories_id' => $productCategory->id,
            'name'        => 'Batata Rústica 500g',
            'description' => '500 gramas de batata frita rústica.',
            'value'       => '19.90',
            'cost'        => '8',
        ]);

        $productCategory = ProductCategory::factory()->create([
            'description' => 'Sobremesas',
        ]);

        Product::factory()->create([
            'atcm_products_categories_id' => $productCategory->id,
            'name'        => 'Pudim',
            'description' => 'Mini Pudim de Copo.',
            'value'       => '7.90',
            'cost'        => '3',
        ]);

        Product::factory()->create([
            'atcm_products_categories_id' => $productCategory->id,
            'name'        => 'Torta de Limão',
            'description' => '1x pedaço torta de limão.',
            'value'       => '12.90',
            'cost'        => '5',
        ]);

        $productCategory = ProductCategory::factory()->create([
            'description' => 'Bebidas',
        ]);

        Product::factory()->create([
            'atcm_products_categories_id' => $productCategory->id,
            'name'        => 'Água 300ml (sem gás)',
            'description' => 'Água Mineral Natural s/ gás. 300ml.',
            'value'       => '5.90',
            'cost'        => '1',
        ]);

        Product::factory()->create([
            'atcm_products_categories_id' => $productCategory->id,
            'name'        => 'Água 300ml (com gás)',
            'description' => 'Água Mineral Natural c/ gás. 300ml.',
            'value'       => '5.90',
            'cost'        => '1',
        ]);

        Product::factory()->create([
            'atcm_products_categories_id' => $productCategory->id,
            'name'        => 'Coca Cola 350ml',
            'description' => 'Refrigerante de Cola 350ml',
            'value'       => '6',
            'cost'        => '2',
        ]);

        Product::factory()->create([
            'atcm_products_categories_id' => $productCategory->id,
            'name'        => 'Coca Cola 350ml (Sem Açucar)',
            'description' => 'Refrigerante de Cola 350ml (Sem Açucar)',
            'value'       => '6',
            'cost'        => '2',
        ]);

        Product::factory()->create([
            'atcm_products_categories_id' => $productCategory->id,
            'name'        => 'Coca Cola 2l',
            'description' => 'Refrigerante de Cola 2 litros.',
            'value'       => '14.50',
            'cost'        => '6',
        ]);

        $date = now()->subMonth()->startOfMonth();

        for ($i = 0; $i < 30; $i ++) {
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

            $date->addDay();
        }

        $date = now()->startOfMonth();

        for ($i = 0; $i < now()->day; $i++) {
            $order = Order::factory()->create([
                'atcm_card_id' => Card::find(rand(1, 100)),
                'status' => OrderStatus::Concluded->value,
            ]);

            for ($z = 0; $z <= rand(6, 12); $z++) { 
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
            
            $date->addDay();
        }
    }
}
