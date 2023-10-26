<?php

namespace App\Actions;
use App\Models\EnterpriseUser;

class CreateNewEnterpriseUserAction
{
    public static function handle(array $enterpriseUserData): EnterpriseUser
    {
        return EnterpriseUser::create([
        ]);
    }
}
