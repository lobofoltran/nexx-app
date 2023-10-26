<?php

namespace App\Actions;
use App\Models\Department;

class CreateNewDepartmentAction
{
    public static function handle(array $departmentData): Department
    {
        return Department::create([
        ]);
    }
}
