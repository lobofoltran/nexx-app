<?php

namespace App\Actions;
use App\Models\ProductCategory;

class CreateNewProductCategoryAction
{
    public function handle(array $productCategoryData): ProductCategory
    {
        return ProductCategory::create([
        ]);
    }
}
