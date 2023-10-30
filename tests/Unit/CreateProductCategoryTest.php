<?php

namespace Tests\Unit;

use App\Actions\CreateNewProductCategoryAction;
use Tests\TestCase;

class CreateProductCategoryTest extends TestCase
{
    public function test_product_category_can_created(): void
    {
        $productCategory = CreateNewProductCategoryAction::handle('Descrição teste');

        $this->assertTrue($productCategory->exists());
    }

    public function test_product_category_attraction_can_created(): void
    {
        $productCategory = CreateNewProductCategoryAction::handle('Atrações', true);

        $this->assertTrue($productCategory->exists());
        $this->assertTrue($productCategory->is_attraction);
    }
}
