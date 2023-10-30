<?php

namespace App\Actions;

use App\Models\ProductEntity;
use App\Models\ProductEntityMovimentation;

class CreateNewProductEntityMovimentationAction
{
    private static string $user_id;
    private static string $product_entity_id;

    public static function handle(?ProductEntity $productEntity = null, ?string $modelType = null, ?string $modelId = null, ?string $action = null, ?string $details = null): ProductEntityMovimentation
    {
        self::validate($productEntity, $modelType, $modelId);

        $productEntityMovimentation = new ProductEntityMovimentation;
        $productEntityMovimentation->atcm_product_entity_id = self::$product_entity_id;
        $productEntityMovimentation->user_id = self::$user_id;
        $productEntityMovimentation->model_type = $modelType;
        $productEntityMovimentation->model_id = $modelId;
        $productEntityMovimentation->action = $action;
        $productEntityMovimentation->details = $details;
        $productEntityMovimentation->save();

        CreateNewAuditLogAction::handle($modelType, $modelId, $action, $details);

        return $productEntityMovimentation;
    }

    private static function validate(?ProductEntity $productEntity, ?string $modelType, ?string $modelId): void
    {
        if (auth()->user()) {
            self::$user_id = auth()->user()->id;
        } else {
            if (env('APP_ENV') == 'testing') {
                self::$user_id = 1;
            } else {
                throw new \Exception(__('Usuário não existe!'), 2);
            }
        }

        if ($productEntity) {
            if (!$productEntity->exists()) throw new \Exception(__('Comanda não existe!'), 3);

            self::$product_entity_id = $productEntity->id;
        } else {
            throw new \Exception(__('Comanda não existe!'), 4);
        }

        if (!$modelType) throw new \Exception(__('Model Type não identificado!'), 5);
        if (!$modelId) throw new \Exception(__('Model Id não identificado!'), 6);
    }
}
