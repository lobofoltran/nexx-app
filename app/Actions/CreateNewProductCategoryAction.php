<?php

namespace App\Actions;
use App\Models\ProductCategory;

class CreateNewProductCategoryAction
{
    public static function handle(array $productCategoryData): ProductCategory
    {
        return ProductCategory::create([
        ]);
    }
}
