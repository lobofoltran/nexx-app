<?php

namespace App\Actions;
use App\Models\Table;

class UpdateTableAction
{
    public static function handle(Table $table, array $tableData): Table
    {
        return $table;
    }
}
