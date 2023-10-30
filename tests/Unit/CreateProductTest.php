<?php

namespace Tests\Unit;

use App\Actions\CreateNewProductAction;
use App\Actions\CreateNewProductCategoryAction;
use Tests\TestCase;

class CreateProductTest extends TestCase
{
    public function test_product_can_created(): void
    {
        $productCategory = CreateNewProductCategoryAction::handle('Descrição teste');
    
        $product = CreateNewProductAction::handle($productCategory, 'Produto teste');
        
        $this->assertTrue($productCategory->exists());
        $this->assertTrue($product->exists());
    }
}
