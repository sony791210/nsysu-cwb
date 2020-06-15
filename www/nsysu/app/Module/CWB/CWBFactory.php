<?php

namespace App\Module\CWB;



class CWBFactory 
{
    public static function create($action, $constructor_param = null)
    {
        $class_name = '\\App\\Module\\CWB' . ucfirst($action) . 'Repository';
        if ( ! class_exists($class_name)) {
            throw new \Exception("Error ResultData $class_name");
        }

        return new $class_name($constructor_param);
    }
}
