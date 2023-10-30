<?php

namespace App\Actions;

use App\Enums\ProductEntityStatus;
use App\Models\Product;
use App\Models\ProductEntity;

class CreateNewProductEntityAction
{
    private static string $product_id;

    public static function handle(?Product $product, ?string $name = null): ProductEntity
    {
        self::validate($product, $name);

        $productEntity = new ProductEntity;
        $productEntity->atcm_product_id = self::$product_id;
        $productEntity->name = trim($name);
        $productEntity->active = true;
        $productEntity->status = ProductEntityStatus::Available->value;
        $productEntity->save();

        CreateNewProductEntityMovimentationAction::handle($productEntity, ProductEntity::class, $productEntity->id, 'create', 'Criada a Entidade de Produto');

        return $productEntity;
    }

    private static function validate(?Product $product, ?string $name): void
    {
        if ($product) {
            if (!$product->exists())
                throw new \Exception(__('Produto não existe!'), 1);

            self::$product_id = $product->id;
        } else {
            throw new \Exception(__('Produto não existe!'), 2);
        }

        if (!$name) throw new \Exception(__('Nome da entidade não identificada!'), 3);    
    }
}
