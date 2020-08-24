<?php

namespace App\Module\News;

use App\Module\ImageBase;

class NewsImg extends ImageBase
{
    protected $guarded = ['id'];
    protected $table = 'images';
}
