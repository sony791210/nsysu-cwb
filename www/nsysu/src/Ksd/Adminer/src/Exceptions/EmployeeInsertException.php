<?php

namespace Ksd\Adminer\Exceptions;

class EmployeeInsertException extends \Exception
{
    public function __construct($message = '新增失敗', $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
