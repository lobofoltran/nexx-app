<?php

namespace App\Actions;

use App\Models\Call;
use App\Models\Table;

class CreateNewCallAction
{
    public static function handle(?Table $table = null, ?string $type = null): Call
    {
        self::validate($table);

        $call = new Call;
        $call->atcm_table_id = $table->id;
        $call->type = $type;
        $call->done = false;
        $call->save();

        CreateNewTableMovimentationAction::handle($table, Table::class, $table->id, 'update', 'Mesa chamando: ' . $type);

        return $call;
    }

    private static function validate(?Table $table): void
    {
        if ($table) {
            if (!$table->exists()) throw new \Exception(__('Mesa não existe!'), 1);
        } else {
            throw new \Exception(__('Mesa não existe!'), 2);
        }
    }
}
