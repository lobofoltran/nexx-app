<?php

namespace App\Actions;
use App\Models\Table;

class UpdateTableAction
{
    public static function handle(Table $table, ?string $identity = null): Table
    {
        $table->identity = trim($identity);
        $table->save();
        
        if ($table->identity != $identity) CreateNewTableMovimentationAction::handle($table, Table::class, $table->id, 'update', 'Atualizada identificação para "'. trim($identity) .'"');

        return $table;
    }
}
