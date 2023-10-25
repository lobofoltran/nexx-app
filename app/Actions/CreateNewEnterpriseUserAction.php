<?php

namespace App\Actions;
use App\Models\EnterpriseUser;

class CreateNewEnterpriseUserAction
{
    public function handle(array $enterpriseUserData): EnterpriseUser
    {
        return EnterpriseUser::create([
        ]);
    }
}
