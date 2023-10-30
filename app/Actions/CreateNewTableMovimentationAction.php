<?php

namespace App\Actions;

use App\Models\Table;
use App\Models\TableMovimentation;

class CreateNewTableMovimentationAction
{
    private static string $user_id;
    private static string $table_id;

    public static function handle(?Table $table = null, ?string $modelType = null, ?string $modelId = null, ?string $action = null, ?string $details = null): TableMovimentation
    {
        self::validate($table, $modelType, $modelId);

        $tableMovimentation = new TableMovimentation;
        $tableMovimentation->atcm_Table_id = self::$table_id;
        $tableMovimentation->user_id = self::$user_id;
        $tableMovimentation->model_type = $modelType;
        $tableMovimentation->model_id = $modelId;
        $tableMovimentation->action = $action;
        $tableMovimentation->details = $details;
        $tableMovimentation->save();

        CreateNewAuditLogAction::handle($modelType, $modelId, $action, $details);

        return $tableMovimentation;
    }

    private static function validate(?Table $table, ?string $modelType, ?string $modelId): void
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

        if ($table) {
            if (!$table->exists()) throw new \Exception(__('Comanda não existe!'), 3);

            self::$table_id = $table->id;
        } else {
            throw new \Exception(__('Comanda não existe!'), 4);
        }

        if (!$modelType) throw new \Exception(__('Model Type não identificado!'), 5);
        if (!$modelId) throw new \Exception(__('Model Id não identificado!'), 6);
    }
}
