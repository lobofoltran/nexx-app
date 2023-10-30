<?php

namespace App\Actions;

use App\Models\ProductCategory;

class CreateNewProductCategoryAction
{
    public static function handle(?string $description = null, bool $is_attraction = false): ProductCategory
    {
        self::validate($description);

        $productCategory = new ProductCategory;
        $productCategory->description = trim($description);
        $productCategory->is_attraction = $is_attraction;
        $productCategory->save();

        CreateNewAuditLogAction::handle(ProductCategory::class, $productCategory->id, 'create', 'Criada a Categoria de Produto');

        return $productCategory;
    }

    private static function validate(?string $description): void
    {
        if (!$description) throw new \Exception(__('Descrição da categoria de produtos não informada!'), 1);
    }
}
