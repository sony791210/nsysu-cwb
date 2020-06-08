<?php

namespace Ksd\Adminer\Exceptions;

class EmployeeUpdateException extends \Exception
{
    public function __construct($message = '更新失敗', $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
