<?php

namespace App\Actions;

use App\Models\LogsQrCode;

class CreateNewLogsQrCodeAction
{
    public static $owner_id;

    public static function handle(string $class, string $id, string $ip_address): LogsQrCode
    {
        self::validate($class, $id);

        $logsQrCode = new LogsQrCode;
        $logsQrCode->model = $class;
        $logsQrCode->id_model = $id;
        $logsQrCode->ip_address = $ip_address;
        $logsQrCode->owner_id = self::$owner_id;
        $logsQrCode->save();

        return $logsQrCode;
    }

    public static function validate(string $class, string $id): void
    {
        $model = $class::find($id);

        if (!$model) {
            throw new \Exception("Erro ao inserir Log! " . $class . ' : ' . $id . " não encontrado!");
        }

        static::$owner_id = $model->owner_id;
    }
}
