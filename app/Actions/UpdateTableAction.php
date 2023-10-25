<?php

namespace App\Actions;
use App\Models\Table;

class UpdateTableAction
{
    public function handle(Table $table, array $tableData): Table
    {
        return $table;
    }
}
