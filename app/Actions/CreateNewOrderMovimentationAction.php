<?php

namespace App\Actions;

use App\Models\Order;
use App\Models\OrderMovimentation;

class CreateNewOrderMovimentationAction
{
    private static string $user_id;
    private static string $order_id;

    public static function handle(?Order $order = null, ?string $modelType = null, ?string $modelId = null, ?string $action = null, ?string $details = null): OrderMovimentation
    {
        self::validate($order, $modelType, $modelId);

        $orderMovimentation = new OrderMovimentation;
        $orderMovimentation->atcm_Order_id = self::$order_id;
        $orderMovimentation->user_id = self::$user_id;
        $orderMovimentation->model_type = $modelType;
        $orderMovimentation->model_id = $modelId;
        $orderMovimentation->action = $action;
        $orderMovimentation->details = $details;
        $orderMovimentation->save();

        CreateNewAuditLogAction::handle($modelType, $modelId, $action, $details);

        return $orderMovimentation;
    }

    private static function validate(?Order $order, ?string $modelType, ?string $modelId): void
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

        if ($order) {
            if (!$order->exists()) throw new \Exception(__('Comanda não existe!'), 3);

            self::$order_id = $order->id;
        } else {
            throw new \Exception(__('Comanda não existe!'), 4);
        }

        if (!$modelType) throw new \Exception(__('Model Type não identificado!'), 5);
        if (!$modelId) throw new \Exception(__('Model Id não identificado!'), 6);
    }
}
