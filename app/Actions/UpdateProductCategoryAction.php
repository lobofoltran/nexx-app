<?php

namespace App\Actions;
use App\Models\ProductCategory;

class UpdateProductCategoryAction
{
    public function handle(ProductCategory $productCategory, array $productCategoryData): ProductCategory
    {
        return $productCategory;
    }
}
