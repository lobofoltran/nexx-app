<?php

namespace App\Actions;

use App\Models\Table;
use App\Models\GroupTable;
use App\Services\TableService;

class CreateNewGroupTableAction
{
    private static string $table_id;
    private static string $table_to_id;

    public static function handle(?Table $table, ?Table $toTable): GroupTable
    {
        self::validate($table, $toTable);

        $groupTable = new GroupTable;
        $groupTable->atcm_table_id = self::$table_id;
        $groupTable->atcm_table_id_to = self::$table_to_id;
        $groupTable->save();

        $groupTable = new GroupTable;
        $groupTable->atcm_table_id = self::$table_to_id;
        $groupTable->atcm_table_id_to = self::$table_id;
        $groupTable->save();

        CreateNewTableMovimentationAction::handle($table, Table::class, $table->id, 'update', 'Vínculo criado com a mesa "' . $toTable->id . '"');

        TableService::setGrouped($table, $toTable);

        return $groupTable;
    }

    private static function validate(?Table $table, ?Table $toTable): void
    {
        if ($table) {
            if (!$table->exists()) throw new \Exception(__('Mesa não existe!'), 1);
        } else {
            throw new \Exception(__('Mesa não existe!'), 2);
        }

        if ($toTable) {
            if (!$toTable->exists()) throw new \Exception(__('Mesa não existe!'), 3);
        } else {
            throw new \Exception(__('Mesa não existe!'), 4);
        }

        if ($table->id == $toTable->id) {
            throw new \Exception(__('Mesa não pode ser a mesma!'), 5);
        }

        self::$table_id = $table->id;
        self::$table_to_id = $toTable->id;
    }
}
