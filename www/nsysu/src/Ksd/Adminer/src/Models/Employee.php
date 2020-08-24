<?php

namespace Ksd\Adminer\Models;

use Ksd\Adminer\Models\BaseModel;
use Log;

class Employee extends BaseModel
{

    /**
     * setting primaryKey's column name
     *
     * @var string
     */
    protected $primaryKey = 'employee_id';

     /**
     * setting UPDATED_AT's column name
     */
    const UPDATED_AT = 'updated_at';

    public function role()
    {
        return $this->belongsToMany('Ksd\Adminer\Models\Role', 'employee_role', 'employee_id', 'role_id');
    }

    public function getRawRole()
    {
        return $this->role->map(function($item) {
            return $item->id;
        });
    }
}
