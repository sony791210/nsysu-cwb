<?php

namespace Ksd\Adminer\Traits;

use Session;
use Log;
use Config;

trait EmployeeValidator
{
    static private $forceViewAs = false;

    /**
    * 確認目前登入的成員是否有效
    * @return boolean
    */
    public function isEmployeeValid()
    {

        if (Session::has('employee')) {
            // TODO: 更細節的驗證，是否會員被刪除或權限有被修改需要登出
            return true;
        }
        return false;
    }

    /**
     * 確認成員有指定的權限
     * @param $acl
     * @return bool
     */
    public function hasOneAcl($acl)
    {
        if ($this->isAdminer()) {
            // 是管理員直接放行
            return true;
        }

        return $this->employeeHasAcl([$acl]);
    }

    /**
    * 確認成員有指定的權限
    * @param array  $requiredAcl
    * @return bool
    */
    public function employeeHasAcl($requiredAcl = [])
    {
        if ($this->isAdminer()) {
            // 是管理員直接放行
            return true;
        }
        // 吻合數一定要一樣
        if ($this->aclMatchNums($requiredAcl) === count($requiredAcl)) {
            return true;
        }
        return false;
    }

    /**
     * Alias to memberHasAcl
     * @param  array $requiredAcl
     * @return bool
     */
    public function aclHas($requiredAcl = [])
    {
        return $this->employeeHasAcl($requiredAcl);
    }

    /**
     * 權限有其中一項即滿足條件
     * @param   array   $acl
     * @return  bool
     */
    public function aclIncludeOne($acl)
    {
        if ($this->isAdminer()) {
            // 是管理員直接放行
            return true;
        }
        if ($this->aclMatchNums($acl) >= 1) {
            return true;
        }
        return false;
    }

    /**
     * 當前登入者的權限與要求權限符合數目
     * @param  array    $acl    要求權限
     * @return integer          符合數目
     */
    public function aclMatchNums($acl)
    {
        $diff = array_intersect($this->getEmployeeRawAcl(), $acl);
        return count($diff);
    }

    /**
    * 是否是管理員身份
    *
    * @return bool
    */
    public function isAdminer()
    {
        // 只要是身份在此清單內，全部放行
        return in_array(Session::get('employee.name'), config('acl.adminer'));
    }

    /**
    * 取得純粹的身份字串
    * @return array
    */
    public function getEmployeeRawRole()
    {
        $employeeRoles = (!self::$forceViewAs && Session::has('viewas.role')) ?
            Session::get('viewas.role') : Session::get('employee.role');
        // 整理出單純的字串
        // ex: ['role_1', 'role_2']
        return $employeeRoles->map(function ($role) {
            return $role->name;
        })->all();
    }

    /**
    * 取得純粹的權限字串
    * @return array
    */
    public function getEmployeeRawAcl()
    {
        $employeeRoles = (!self::$forceViewAs && Session::has('viewas.role')) ?
            Session::get('viewas.role') : Session::get('employee.role');
        $result = [];
        foreach ($employeeRoles as $role) {
            foreach ($role->acl as $acl) {
                if (!in_array($acl->name, $result)) {
                    $result[] = $acl->name;
                }
            }
        }
        return $result;
    }

    /**
     * 忽略檢視角度，在匿名函示內都會直接讀取原本的會員
     * @param function $func
     * @return void
     */
    public function aclForceView($func)
    {
        try {
            self::$forceViewAs = true;
            return $func();
        } finally {
            self::$forceViewAs = false;
        }
    }

    /**
     * 確認現在是否是檢視角度的狀態
     * @return bool
     */
    public function inViewAsMode()
    {
        return Session::has('viewas');
    }
}
