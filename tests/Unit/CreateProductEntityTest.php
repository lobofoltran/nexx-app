<?php

namespace Tests\Unit;

use App\Actions\CreateNewProductAction;
use App\Actions\CreateNewProductCategoryAction;
use App\Actions\CreateNewProductEntityAction;
use Tests\TestCase;

class CreateProductEntityTest extends TestCase
{
    public function test_product_entity_can_created(): void
    {
        $productCategory = CreateNewProductCategoryAction::handle('Descrição teste');
    
        $product = CreateNewProductAction::handle($productCategory, 'Produto teste');

        $productEntity = CreateNewProductEntityAction::handle($product, 'Entidade teste');

        $this->assertTrue($productCategory->exists());
        $this->assertTrue($product->exists());
        $this->assertTrue($productEntity->exists());
    }
}
