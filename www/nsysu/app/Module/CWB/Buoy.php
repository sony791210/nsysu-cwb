<?php

namespace App\Module\CWB;

use Illuminate\Database\Eloquent\Model;

class Buoy extends Model
{
    //
    protected $connection = 'CWBData';
    protected $table = 'cwbWeatherBuoy';
}
