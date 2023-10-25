<?php

namespace App\Actions;
use App\Models\Department;

class UpdateDepartmentAction
{
    public function handle(Department $department, array $departmentData): Department
    {
        return $department;
    }
}
