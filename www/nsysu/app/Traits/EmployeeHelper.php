<?php
/**
 * User: lee
 * Date: 2018/05/29
 * Time: 上午 10:03
 */

namespace App\Traits;

use App\Traits\JWTTokenHelper;

trait EmployeeHelper
{
    use JWTTokenHelper;

    /**
     * 取得員工 ID
     * @return int|null
     */
    public function getEmployeeId()
    {
        $tokenData = $this->JWTdecode();

        return ($tokenData) ? $tokenData->id : null;
    }
}
