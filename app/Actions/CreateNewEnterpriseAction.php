<?php

namespace App\Actions;

use App\Models\Enterprise;

class CreateNewEnterpriseAction
{
    public static function handle(?string $name = null): Enterprise
    {
        self::validate($name);

        $enterprise = new Enterprise;
        $enterprise->name = trim($name);
        $enterprise->active = true;
        $enterprise->free_to_pay = true;
        $enterprise->save();

        return $enterprise;
    }

    private static function validate(?string $name): void
    {
        if (!$name) throw new \Exception(__('Nome da empresa não informado!'), 1);
    }
}
