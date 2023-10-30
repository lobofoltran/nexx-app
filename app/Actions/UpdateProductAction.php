<?php

namespace App\Actions;
use App\Models\Product;
use App\Models\ProductCategory;

class UpdateProductAction
{    
    private static string $product_category_id;
    private static string $textLog;

    public static function handle(
        Product $product, 
        ?ProductCategory $productCategory, 
        ?string $name = null,
        ?string $value = '0',
        ?string $description = null,
        ?string $image_url = null,
        bool $active = true, 
        bool $show_to_waiter = false,
        bool $show_to_kitchen = false,
        bool $show_to_cashier = false
    ): Product {
        self::validate($product, $productCategory, $name, $value, $description, $active);

        $product->atcm_products_categories_id = self::$product_category_id;
        $product->name = trim($name);
        $product->value = $value;
        $product->description = trim($description);
        $product->active = $active;
        $product->show_to_waiter = $show_to_waiter;
        $product->show_to_kitchen = $show_to_kitchen;
        $product->show_to_cashier = $show_to_cashier;
        $product->image_url = $image_url;
        $product->save();

        if (self::$textLog) CreateNewAuditLogAction::handle(Product::class, $product->id, 'update', self::$textLog);

        return $product;
    }

    private static function validate(
        Product $product, 
        ?ProductCategory $productCategory, 
        ?string $name, 
        ?string $value = '0',
        ?string $description = null,
        bool $active = true
    ): void {

        if ($productCategory) {
            if ($product->productCategory->is_attraction != $productCategory->is_attraction)
                throw new \Exception(__('Não é possível trocar a categoria de um produto para categoria de atração/vice versa.'), 1);

            self::$product_category_id = $productCategory->id;
        } else {
            self::$product_category_id = $product->productCategory->id;
        }

        if (!$name) {
            throw new \Exception(__('Nome do produto não informado!'), 2);
        }

        self::$textLog = 'Atualizado produto:';
        if ($productCategory != $product->productCategory) self::$textLog .= ' Categoria de produto: (' . $product->productCategory . ') -> ' . $productCategory . ';';
        if ($name != $product->name) self::$textLog .= ' Nome: (' . $product->name . ') -> ' . $name . ';';
        if ($value != $product->value) self::$textLog .= ' Valor: (' . $product->value . ') -> ' . $value . ';';
        if ($description != $product->description) self::$textLog .= ' Descrição: (' . $product->description . ') -> ' . $description . ';';
        if ($active != $product->active) self::$textLog .= ' Ativo: (' . $product->active . ') -> ' . $active . ';';
    }
}
