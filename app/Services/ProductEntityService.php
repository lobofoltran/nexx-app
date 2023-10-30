<?php

namespace App\Services;
use App\Actions\CreateNewProductEntityMovimentationAction;
use App\Enums\ProductEntityStatus;
use App\Models\ProductEntity;

class ProductEntityService
{
    public static function setAvailable(ProductEntity $productEntity): ProductEntity
    {
        $productEntity->status = ProductEntityStatus::Available->value;
        $productEntity->save();

        CreateNewProductEntityMovimentationAction::handle($productEntity, ProductEntity::class, $productEntity->id, 'update', 'Status da Entidade de Produto altera para "Disponível"');

        return $productEntity;
    }

    public static function setInUse(ProductEntity $productEntity): ProductEntity
    {
        $productEntity->status = ProductEntityStatus::InUse->value;
        $productEntity->save();

        CreateNewProductEntityMovimentationAction::handle($productEntity, ProductEntity::class, $productEntity->id, 'update', 'Status da Entidade de Produto altera para "Em Uso"');

        return $productEntity;
    }

    public static function setDisabled(ProductEntity $productEntity): ProductEntity
    {
        $productEntity->status = ProductEntityStatus::Disabled->value;
        $productEntity->save();

        CreateNewProductEntityMovimentationAction::handle($productEntity, ProductEntity::class, $productEntity->id, 'update', 'Status da Entidade de Produto altera para "Desabilitada"');

        return $productEntity;
    }
}