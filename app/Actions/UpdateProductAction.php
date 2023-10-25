<?php

namespace App\Actions;
use App\Models\Product;

class UpdateProductAction
{
    public function handle(Product $product, array $productData): Product
    {
        return $product;
    }
}
