<?php

namespace App\Actions;
use App\Models\ProductEntity;

class CreateNewProductEntityAction
{
    public static function handle(array $productEntityData): ProductEntity
    {
        return ProductEntity::create([
        ]);
    }
}
