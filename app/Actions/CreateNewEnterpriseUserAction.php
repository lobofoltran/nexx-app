<?php

namespace App\Actions;

use App\Models\Enterprise;
use App\Models\EnterpriseUser;
use App\Models\User;

class CreateNewEnterpriseUserAction
{
    private static string $user_id;

    private static string $enterprise_id;

    public static function handle(?User $user, ?Enterprise $enterprise): EnterpriseUser
    {
        self::validate($user, $enterprise);

        $enterpriseUser = new EnterpriseUser;
        $enterpriseUser->user_id = self::$user_id;
        $enterpriseUser->enterprise_id = self::$enterprise_id;
        $enterpriseUser->save();

        return $enterpriseUser;
    }

    private static function validate(?User $user, ?Enterprise $enterprise): void
    {
        if ($user) {
            if (!$user->exists()) throw new \Exception(__('Usuário não existe!'), 1);
        } else {
            throw new \Exception(__('Usuário não existe!'), 2);
        }

        if ($enterprise) {
            if (!$enterprise->exists()) throw new \Exception(__('Empresa não existe!'), 3);
        } else {
            throw new \Exception(__('Empresa não existe!'), 4);
        }

        self::$user_id = $user->id;
        self::$enterprise_id = $enterprise->id;
    }
}
