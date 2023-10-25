<?php

namespace App\Actions;
use App\Models\Enterprise;

class CreateNewEnterpriseAction
{
    public function handle(array $entepriseData): Enterprise
    {
        return Enterprise::create([
        ]);
    }
}
