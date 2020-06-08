<?php

namespace Ksd\Adminer\Repositories;

use Ksd\Adminer\Models\Role;

class RoleRepository
{
    protected $model;

    public function __construct(Role $model)
    {
        $this->model = $model;
    }

    /**
     * 新增角色
     * @param array $attrs
     * @return Ksd\Adminer\Models\Role
     */
    public function add($attrs)
    {
        $role = new Role();
        foreach ($attrs as $key => $val) {
            $role->$key = $val;
        }
        $role->save();
        return $role;
    }

    /**
     * 更新角色
     * @param  integer  $id
     * @param  array    $attrs
     * @return Ksd\Adminer\Models\Role
     */
    public function update($id, $attrs)
    {
        $role = $this->find($id);
        if (empty($role)) {
            return false;
        }
        foreach ($attrs as $key => $val) {
            $role->$key = $val;
        }
        $role->save();
        return $role;
    }

    /**
     * 取得所有角色
     * @return Collection
     */
    public function get()
    {
        return $this->model->with(['acl'])->get();
    }

    /**
    * 使用id來查找角色
    *
    * @param integer $id
    * @return Ksd\Adminer\Models\Role
    */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * 使用角色名稱取得擁有的成員(可多筆角色一起查)
     * @param array<string> $name
     * @return Collection
     */
    public function getOwnEmployeesByName($name)
    {
        return $this->model->with('employee')->whereIn('name', $name)->get();
    }
}
