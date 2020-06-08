<?php

namespace Ksd\Adminer\Traits;

use Session;
use Ksd\Adminer\Models\Employee;

trait EmployeeManager
{
    /**
    * 登出目前成員
    * @return void
    */
    public function signOut()
    {
        Session::forget('employee');
        Session::forget('viewas');
    }

    /**
    * 取得當前登入的成員資訊
    * @return Ksd\Adminer\Models\Member
    */
    public function getCurrentEmployee()
    {
        return Session::get('employee');
    }

    /**
     * 切換檢視角度
     * @param Ksd\Adminer\Models\Member $member
     * @return void
     */
    public function viewAs(Employee $employee)
    {
        Session::put('viewas', $employee);
    }

    /**
     * 結束檢視角度
     * @return void
     */
    public function exitViewAs()
    {
        Session::forget('viewas');
    }
}
