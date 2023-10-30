<?php

namespace App\Actions;

use App\Models\Card;
use App\Models\CardMovimentation;

class CreateNewCardMovimentationAction
{
    private static string $user_id;
    private static string $card_id;

    public static function handle(?Card $card = null, ?string $modelType = null, ?string $modelId = null, ?string $action = null, ?string $details = null): CardMovimentation
    {
        self::validate($card, $modelType, $modelId);

        $cardMovimentation = new CardMovimentation;
        $cardMovimentation->atcm_card_id = self::$card_id;
        $cardMovimentation->user_id = self::$user_id;
        $cardMovimentation->model_type = $modelType;
        $cardMovimentation->model_id = $modelId;
        $cardMovimentation->action = $action;
        $cardMovimentation->details = $details;
        $cardMovimentation->save();

        CreateNewAuditLogAction::handle($modelType, $modelId, $action, $details);

        return $cardMovimentation;
    }

    private static function validate(?Card $card, ?string $modelType, ?string $modelId): void
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

        if ($card) {
            if (!$card->exists()) throw new \Exception(__('Comanda não existe!'), 3);

            self::$card_id = $card->id;
        } else {
            throw new \Exception(__('Comanda não existe!'), 4);
        }

        if (!$modelType) throw new \Exception(__('Model Type não identificado!'), 5);
        if (!$modelId) throw new \Exception(__('Model Id não identificado!'), 6);
    }
}
