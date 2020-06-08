<?php

namespace App\Core;

class Hash
{
    /**
     * [mask hash string]
     * @param  string  $password   [密碼]
     * @return string
     */
    public static function make($password = '')
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * [check password]
     * @param  string  $password   [密碼]
     * @param  string  $hash   [hash密碼]
     * @return boolean
     */
    public static function check($password = '', $hash = '')
    {
        return password_verify($password, $hash);
    }
}
