<?php
/**
 * User: lee
 * Date: 2018/04/30
 * Time: 上午 9:30
 */

namespace App\Exceptions;

class ErrorCode
{
    /**
     * A list of the exception types.
     *
     * @var array
     */
    protected $errorCodes = [
        'E0001' => '傳送參數錯誤',
        'E0002' => '新增失敗',
        'E0003' => '更新失敗',
        'E0004' => '刪除失敗',
        'E0005' => '資料無法取得',
        'E0006' => '錯誤的登入資訊',

        // token access
        'E0021' => '會員驗證失效',
        'E0022' => '無法驗證Token',
        'E0023' => '無法取得Token',
        'E0025' => 'Token產生失敗',
        'E0026' => 'Token更新失敗',
        'E0027' => '授權方式錯誤',
        'E0028' => 'Token逾時',

        'E0061' => '會員不存在',
    ];

    public static function message($code)
    {
        $self = new static;
        return (isset($self->errorCodes[$code])) ? $self->errorCodes[$code] : '未知錯誤訊息';
    }

    public static function isDefinedError($code)
    {
        $self = new static;
        if (array_key_exists($code, $self->errorCodes)) {
            return true;
        }
        return false;

    }
}
