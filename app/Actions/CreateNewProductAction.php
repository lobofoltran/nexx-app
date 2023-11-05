<?php

namespace App\Actions;

use App\Models\Product;
use App\Models\ProductCategory;

class CreateNewProductAction
{
    private static string $productCategory_id;

    public static function handle(
        ?ProductCategory $productCategory = null,
        ?string $name = null,
        ?string $description = null,
        bool $show_to_bar = false,
        bool $show_to_kitchen = false,
        bool $show_to_cashier = false,
        ?string $image_url = null,
        string $time = '0',
        string $value = '0',
    ): Product {
        self::validate($productCategory, $name);

        $product = new Product;
        $product->atcm_products_categories_id = self::$productCategory_id;
        $product->active = true;
        $product->name = trim($name);
        $product->time = $time;
        $product->description = $description;
        $product->show_to_bar = $show_to_bar;
        $product->show_to_kitchen = $show_to_kitchen;
        $product->show_to_cashier = $show_to_cashier;
        $product->image_url = $image_url;
        $product->value = $value;
        $product->save();

        CreateNewAuditLogAction::handle(Product::class, $product->id, 'create', 'Criado o Produto');

        return $product;
    }

    private static function validate(?ProductCategory $productCategory, ?string $name): void
    {
        if ($productCategory) {
            if (!$productCategory->exists()) throw new \Exception(__('Categoria de produtos não existe!'), 1);

            self::$productCategory_id = $productCategory->id;
        } else {
            throw new \Exception(__('Categoria de produtos não existe!'), 2);
        }


        if (!$name) throw new \Exception(__('Nome do produto não informado!'), 3);
    }
}
