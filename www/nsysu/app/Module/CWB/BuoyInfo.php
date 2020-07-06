<?php

namespace App\Module\CWB;

use Illuminate\Database\Eloquent\Model;

class BuoyInfo extends Model
{
    //
    protected $connection = 'CWBData';
    protected $table = 'cwbBuoyInfo';
}
