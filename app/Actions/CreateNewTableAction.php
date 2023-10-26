<?php

namespace App\Actions;
use App\Models\Table;

class CreateNewTableAction
{
    public static function handle(array $tableData): Table
    {
        return Table::create([
        ]);
    }
}
