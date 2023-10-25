<?php

namespace App\Actions;
use App\Models\EnterpriseUser;

class UpdateEnterpriseUserAction
{
    public function handle(EnterpriseUser $enterpriseUser, array $enterpriseUserData): EnterpriseUser
    {
        return $enterpriseUser;
    }
}
