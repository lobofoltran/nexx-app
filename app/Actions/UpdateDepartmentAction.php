<?php

namespace App\Actions;
use App\Models\Department;

class UpdateDepartmentAction
{
    public static function handle(Department $department, array $departmentData): Department
    {
        return $department;
    }
}
