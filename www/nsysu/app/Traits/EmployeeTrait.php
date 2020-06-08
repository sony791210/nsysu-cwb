<?php
/**
 * User: lee
 * Date: 2019/02/23
 * Time: 上午 9:42
 */

namespace App\Traits;

trait EmployeeTrait
{

    public function getSupplierId()
    {
        return \Session::get('employee.supplier_id');
    }
    public function getEmployeeId()
    {
        return \Session::get('employee')->employee_id;
    }

}
