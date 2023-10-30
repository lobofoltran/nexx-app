<?php

namespace App\Actions;

use App\Models\Enterprise;

class UpdateEnterpriseAction
{
    public static function handle(Enterprise $enterprise, ?string $name = null, bool $free_to_pay = false): Enterprise
    {
        self::validate($name);

        $enterprise->name = trim($name);
        $enterprise->free_to_pay = $free_to_pay;
        $enterprise->save();

        return $enterprise;
    }

    private static function validate(?string $name): void
    {
        if (!$name)
            throw new \Exception(__('Nome da empresa não informado!'), 1);
    }
}
