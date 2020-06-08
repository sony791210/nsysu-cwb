<?php

namespace App\Module\News;

use App\Module\Base;

class News extends Base
{
    /**
     * setting modle's table name
     *
     * @var string
     */
    protected $table = 'news';

    protected $fillable = [
        'title',
        'datetieme',
        'status',
        'content',
        'picture'];


    protected $primaryKey = 'id';

    public function newsImg()
    {
        return $this->hasOne('App\Module\News\NewsImg','news_id','id');
    }

}
