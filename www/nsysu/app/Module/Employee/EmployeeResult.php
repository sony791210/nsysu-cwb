<?php
/**
 * Created by PhpStorm.
 * User: Annie
 * Date: 2019/11/15
 * Time: 下午 02:10
 */

namespace App\Module\Employee;


use App\Module\BaseResult;

class EmployeeResult extends BaseResult
{
    public function getEmployeeOption($employeeList)
    {
        return $this->getOptions($employeeList, ['value' => 'employee_id', 'label' => 'displayName']);
    }
}