<?php

namespace App\Actions;
use App\Models\EnterpriseUser;

class UpdateEnterpriseUserAction
{
    public static function handle(EnterpriseUser $enterpriseUser, array $enterpriseUserData): EnterpriseUser
    {
        return $enterpriseUser;
    }
}
