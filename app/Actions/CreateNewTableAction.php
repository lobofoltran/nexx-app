<?php

namespace App\Actions;

use App\Enums\TableStatus;
use App\Models\Table;

class CreateNewTableAction
{
    public static function handle(?string $identity = null): Table
    {
        $table = new Table;
        $table->identity = trim($identity);
        $table->status = TableStatus::Available->value;
        $table->cards_quantity = 0;
        $table->save();

        CreateNewTableMovimentationAction::handle($table, Table::class, $table->id, 'create', 'Criada a mesa');

        return $table;
    }
}
