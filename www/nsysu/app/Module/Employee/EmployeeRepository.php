<?php

namespace App\Module\Employee;


class EmployeeRepository
{
    protected $model;

    public function __construct(Employee $employee)
    {
        $this->model = $employee;
    }

    /**
     * get employee's data form citypass backend by id
     *
     * @param integer $id
     * @return App\Models\Backend\Employee
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    public function getEmployeeByCode($code)
    {
        return $this->model
            ->where('personal_code', $code)
            ->where('status', 1)
            ->first();
    }

    public function list()
    {
        return $this->model->active()->get();
    }

    public function getByIds($ids)
    {

        return $this->model->whereIn('employee_id', $ids)->get();
    }
    public function all()
    {

        return $this->model->get();
    }
}
