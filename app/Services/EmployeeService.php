<?php

namespace App\Services;

use App\Repositories\EmployeeRepository;

class EmployeeService
{
    protected $repo;

    public function __construct(EmployeeRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAllEmployees()
    {
        return $this->repo->getAllEmployees();
    }
}
