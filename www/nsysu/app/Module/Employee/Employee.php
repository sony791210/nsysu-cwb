<?php

namespace App\Module\Employee;

use App\Module\Base;
use App\Module\EmployeeLink\EmployeeLink;
use Ksd\Adminer\Models\Role;

class Employee extends Base
{
    /**
     * setting modle's table name
     *
     * @var string
     */
    protected $table = 'employees';

    protected $fillable = [
        'email',
        'name',
        'password',
        'displayName',
        'personal_code',
        'status'];


    protected $primaryKey = 'employee_id';

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function role()
    {
        return $this->hasMany(Role::class);
    }

    public function link()
    {
        return $this->hasMany(EmployeeLink::class);
    }

}
