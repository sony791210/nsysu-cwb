<?php

namespace Ksd\Adminer\Repositories;

use Ksd\Adminer\Models\Employee;
use Log;
use Exception;
use Illuminate\Database\QueryException;

class EmployeeRepository
{
    protected $model;

    public function __construct(Employee $model)
    {
        $this->model = $model;
    }

    /**
     * 使用id查找成員
     *
     * @param integer $id
     * @return Ksd\Member\Models\Mmeber
     */
    public function find($id)
    {
        return $this->model->with(['role.acl'])->find($id);
    }

    /**
     * 使用帳戶名稱查找成員
     *
     * @param string $account
     * @return Ksd\Member\Models\Mmeber
     */
    public function findByAccount($account)
    {
        return $this->model
            ->where('name', $account)
            ->with('role.acl')
            ->first();
    }

    /**
     * 新增成員
     *
     * @param array $data
     * @return Ksd\Member\Models\Mmeber
     */
    public function add($data)
    {
        try {
            $employee = new Employee();
            foreach ($data as $k => $v) {
                $employee->$k = $v;
            }
            $employee->save();
            return $employee;
        } catch (QueryException $e) {
            throw $e;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * 更新成員資訊
     *
     * @param integer $id
     * @param array $data
     * @return Ksd\Member\Models\Mmeber
     */
    public function update($id, $data)
    {
        try {
            $employee = $this->find($id);
            if (is_null($employee)) {
                return false;
            }
            foreach ($data as $k => $v) {
                $employee->$k = $v;
            }
            $employee->save();

            return $employee;
        } catch (QueryException $e) {
            throw $e;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * 取得所有成員
     *
     * @return Collection
     */
    public function get()
    {
        return $this->model->with(['role.acl'])->get();
    }

    /**
     * get Token by id
     *
     * @param int $id
     * @return string
     */
    public function getToken($id)
    {
        $employee = $this->model->where('employee_id', $id)->pluck('employee_token')->first();

        return ($employee != null) ? $employee : '';
    }

    /**
     * search
     *
     * @param array $params
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Employee[]|mixed[]
     */
    public function search($params)
    {
        return $this->model->with(['role.acl', 'supplier'])
            ->when($params['account'], function ($query) use ($params) {
                $query->where('employee_username', 'like', '%' . $params['account'] . '%');
            })
            ->when($params['name'], function ($query) use ($params) {
                $query->where('employee_name', 'like', '%' . $params['name'] . '%');
            })
            ->when($params['email'], function ($query) use ($params) {
                $query->where('employee_email', 'like', '%' . $params['email'] . '%');
            })
            ->get();
    }

    /**
     * 使用餐車id查找成員
     *
     * @param $diningCarId
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|Employee|object
     */
    public function findByDingingCarId($diningCarId)
    {
        return $this->model
            ->with(['role.acl', 'supplier'])
            ->with('diningCar')
            ->whereHas('diningCar', function ($q) use ($diningCarId) {
                return $q->where('id', $diningCarId);
            })
            ->first();
    }
}
