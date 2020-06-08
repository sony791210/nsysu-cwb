<?php

namespace Ksd\Adminer\Models;

use Ksd\Adminer\Models\BaseModel;

class Role extends BaseModel
{
    protected $table = 'role';

    public function acl()
    {
        return $this->belongsToMany('Ksd\Adminer\Models\Acl', 'role_acl', 'role_id', 'acl_id');
    }

    public function member()
    {
        return $this->belongsToMany('Ksd\Adminer\Models\Employee');
    }
}
