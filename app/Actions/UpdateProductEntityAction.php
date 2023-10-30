<?php

namespace App\Actions;
use App\Models\ProductEntity;

class UpdateProductEntityAction
{
    private static string $textLog;

    public static function handle(ProductEntity $productEntity, ?string $name = null, bool $active = true): ProductEntity
    {
        self::validate($productEntity, $name, $active);

        $productEntity->name = trim($name);
        $productEntity->active = $active;
        $productEntity->save();

        if (self::$textLog) CreateNewAuditLogAction::handle(ProductEntity::class, $productEntity->id, 'update', self::$textLog);

        return $productEntity;
    }

    private static function validate(ProductEntity $productEntity, ?string $name, bool $active): void
    {
        if (!trim($name)) {
            throw new \Exception(__('Nome da entidade não identificada!'), 1);
        }

        self::$textLog = 'Atualizado categoria do produto:';
        if ($name != $productEntity->name) self::$textLog .= ' Nome: (' . $productEntity->name . ') -> ' . $name . ';';
        if ($active != $productEntity->active) self::$textLog .= ' Ativo: (' . $productEntity->active . ') -> ' . $active . ';';
    }
}
