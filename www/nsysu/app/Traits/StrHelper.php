<?php

namespace App\Traits;

Trait StrHelper
{
    /**
     * 遮罩第2個字
     * @param $str
     * @return string
     */
    function maskMiddleWords($str, $mask = '*'){
        $strlen     = mb_strlen($str, 'utf-8');
        if ($strlen <= 1) return $str;

        $firstStr     = mb_substr($str, 0, 1, 'utf-8');
        $lastStr     = mb_substr($str, -1, 1, 'utf-8');
        return $strlen == 2 ? $firstStr . str_repeat($mask, mb_strlen($str, 'utf-8') - 1) : $firstStr . str_repeat($mask, $strlen - 2) . $lastStr;
    }
}
