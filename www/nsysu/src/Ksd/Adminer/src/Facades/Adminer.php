<?php

namespace Ksd\Adminer\Facades;

use Illuminate\Support\Facades\Facade;

class Adminer extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Adminer';
    }
}
