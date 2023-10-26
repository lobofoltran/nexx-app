<?php

namespace App\Actions;
use App\Models\Enterprise;

class UpdateEnterpriseAction
{
    public static function handle(Enterprise $enterprise, array $enterpriseData): Enterprise
    {
        return $enterprise;
    }
}
