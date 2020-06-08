<?php

namespace App\Module\Employee;

class EmployeeService
{
    protected $repository;

    public function __construct(EmployeeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function active()
    {
        return $this->repository->list();
    }

    public function getEmployeeByCode($code)
    {
        return $this->repository->getEmployeeByCode($code);
    }

    public function getByIds($employeeLinks)
    {

        return $this->repository->getByIds($employeeLinks);
    }

    public function all()
    {
        return $this->repository->all();
    }

}
