<?php

namespace App\Module;

use Ksd\Adminer\Services\EmployeeService;
use App;

abstract class BasePolicy
{
    public function __construct()
    {
    }

    public function __call($method,$arguments)
    {
        if(method_exists($this, $method)) {
            if ( App::make(EmployeeService::class)->isAdminer()) return true;
            return call_user_func_array(array($this,$method),$arguments);
        }
    }

    protected function isManager()
    {
        return Adminer::isAdminer();
    }
}
