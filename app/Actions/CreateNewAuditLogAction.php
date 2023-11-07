<?php

namespace App\Actions;
use App\Models\AuditLog;


class CreateNewAuditLogAction
{
    private static string $user_id;

    public static function handle(?string $modelType = null, ?string $modelId = null, ?string $action = null, ?string $details = null, bool $schedule = false): AuditLog
    {
        self::validate($modelType, $modelId, $schedule);

        $auditLog = new AuditLog;
        $auditLog->user_id = self::$user_id;
        $auditLog->model_type = $modelType;
        $auditLog->model_id = $modelId;
        $auditLog->action = $action;
        $auditLog->details = $details;
        $auditLog->save();

        return $auditLog;
    }

    private static function validate(?string $modelType, ?string $modelId, bool $schedule): void
    {
        if (auth()->user()) {
            self::$user_id = auth()->user()->id;
        } else {
            if (env('APP_ENV') == 'testing' || $schedule) {
                self::$user_id = 1;
            } else {
                self::$user_id = '1';
                // throw new \Exception(__('Usuário não existe!'), 1);
            }
        }

        if (!$modelType) throw new \Exception(__('Model Type não identificado!'), 2);
        if (!$modelId) throw new \Exception(__('Model Id não identificado!'), 3);
    }
}
