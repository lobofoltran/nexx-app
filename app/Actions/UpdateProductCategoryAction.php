<?php

namespace App\Actions;
use App\Models\ProductCategory;

class UpdateProductCategoryAction
{
    public static function handle(ProductCategory $productCategory, array $productCategoryData): ProductCategory
    {
        return $productCategory;
    }
}
