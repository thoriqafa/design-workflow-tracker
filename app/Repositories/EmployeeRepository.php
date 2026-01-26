<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class EmployeeRepository
{
    public function getAllEmployees()
    {
        return DB::table('employees')->get();
    }
}
