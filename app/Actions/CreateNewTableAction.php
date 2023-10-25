<?php

namespace App\Actions;
use App\Models\Table;

class CreateNewTableAction
{
    public function handle(array $tableData): Table
    {
        return Table::create([
        ]);
    }
}
