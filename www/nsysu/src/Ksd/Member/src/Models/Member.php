<?php
/**
 * User: lee
 * Date: 2017/09/26
 * Time: 上午 9:42
 */

namespace Ksd\Member\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes;

    protected $connection = 'middleware';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
}
