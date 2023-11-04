<?php

namespace App\Actions;

use App\Models\GroupTable;
use App\Models\Table;
use App\Services\TableService;

class DeleteGroupTableAction
{
    public static function handle(?GroupTable $groupTable): void
    {
        self::validate($groupTable);

        $atcm_table_id = $groupTable->atcm_table_id;
        $atcm_table_id_to = $groupTable->atcm_table_id_to;

        $first = GroupTable::where('atcm_table_id', $atcm_table_id)->where('atcm_table_id_to', $atcm_table_id_to)->first();
        $second = GroupTable::where('atcm_table_id_to', $atcm_table_id)->where('atcm_table_id', $atcm_table_id_to)->first();
        $first->delete();
        $second->delete();

        CreateNewTableMovimentationAction::handle(Table::find($atcm_table_id), Table::class, $atcm_table_id, 'update', 'Vínculo removido com a comanda "' . $atcm_table_id_to . '"');
        CreateNewTableMovimentationAction::handle(Table::find($atcm_table_id_to), Table::class, $atcm_table_id_to, 'update', 'Vínculo removido com a comanda "' . $atcm_table_id . '"');
    
        TableService::removeGroupment(Table::find($atcm_table_id), Table::find($atcm_table_id_to));
    }

    private static function validate(?GroupTable $groupTable): void
    {
        if ($groupTable) {
            if (!$groupTable->exists()) throw new \Exception(__('Vínculo não existe!'), 1);
        } else {
            throw new \Exception(__('Vínculo não existe!'), 2);
        }
    }
}
