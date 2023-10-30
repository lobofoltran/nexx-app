<?php

namespace App\Actions;
use App\Models\ProductCategory;

class UpdateProductCategoryAction
{
    public static function handle(ProductCategory $productCategory, ?string $description = null): ProductCategory
    {
        self::validate($description);

        $productCategory->description = trim($description);
        $productCategory->save();

        if ($productCategory->description != $description) CreateNewAuditLogAction::handle(ProductCategory::class, $productCategory->id, 'update', 'Atualizada descrição para "'. $description .'"');

        return $productCategory;
    }

    public static function validate(?string $description = null): void
    {
        if (!$description) {
            throw new \Exception(__('Descrição da categoria de produtos não informada!'), 1);
        }
    }
}
