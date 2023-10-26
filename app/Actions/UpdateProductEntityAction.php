<?php

namespace App\Actions;
use App\Models\ProductEntity;

class UpdateProductEntityAction
{
    public static function handle(ProductEntity $productEntity, array $productEntityData): ProductEntity
    {
        return $productEntity;
    }
}
