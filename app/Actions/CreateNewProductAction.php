<?php

namespace App\Actions;
use App\Models\Product;

class CreateNewProductAction
{
    public static function handle(array $productData): Product
    {
        return Product::create([
        ]);
    }
}
