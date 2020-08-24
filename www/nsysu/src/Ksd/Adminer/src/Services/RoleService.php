<?php

namespace Ksd\Adminer\Services;

use Ksd\Adminer\Repositories\AclRepository;
use Ksd\Adminer\Repositories\RoleRepository;
use Ksd\Adminer\Repositories\EmployeeRepository;
use Ksd\Adminer\Repositories\AclCategoryRepository;
use DB;

class RoleService
{
    /**
    * @var Ksd\Adminer\Repositories\RoleRepository
    */
    protected $roleRepo;

    /**
     * @var Ksd\Adminer\Repositories\RoleRepository
     */
    protected $aclCategoryRepo;

    /**
     * @var Ksd\Adminer\Repositories\AclRepository
     */
    protected $aclRepo;

    /**
     * @var Ksd\Adminer\Repositories\MemberRepository
     */
    protected $memberRepo;

    public function __construct(
        AclRepository $aclRepo,
        RoleRepository $roleRepo,
        AclCategoryRepository $aclCategoryRepo,
        EmployeeRepository $employeeRepo
    ) {
        $this->aclRepo = $aclRepo;
        $this->roleRepo = $roleRepo;
        $this->aclCategoryRepo = $aclCategoryRepo;
        $this->employeeRepo = $employeeRepo;
    }

    /**
     * 新增角色
     * @param array $attrs  角色屬性
     * @param array $acl    權限id
     * @return Ksd\Adminer\Models\Role
     */
    public function add($attrs, $acl = [])
    {
        try {
            DB::beginTransaction();
            $role = $this->roleRepo->add($attrs);
            $role->acl()->sync($acl);
            DB::commit();
            return $role;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * 更新角色
     * @param  integer  $id
     * @param  array    $attrs
     * @param  array    $acl
     * @return Ksd\Adminer\Models\Role
     */
    public function update($id, $attrs, $acl = [])
    {
        try {
            DB::beginTransaction();
            $role = $this->roleRepo->update($id, $attrs);
            $role->acl()->sync($acl);
            DB::commit();
            return $role;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * 取得所有角色
     * @return Collection
     */
    public function getAvailable()
    {
        return $this->roleRepo->get();
    }

    /**
    * 查找單一角色紀錄
    *
    * @param integer $id
    * @return Ksd\Adminer\Models\Role
    */
    public function find($id)
    {
        return $this->roleRepo->find($id);
    }

    /**
    * 取得所有權限類別
    *
    * @return Collection
    */
    public function getAclCategory()
    {
        return $this->aclCategoryRepo->get();
    }

    /**
     * 依分類取得權限
     * @param  integer      $categoryId
     * @return Collection
     */
    public function getAclByCategory($categoryId)
    {
        return $this->aclRepo->getByCategory($categoryId);
    }

    /**
     * 使用角色名稱，取得底下擁有的成員
     * @param  array<string>    $name
     * @return Collection
     */
    public function getOwnEmployeesByName($name)
    {
        return $this->roleRepo->getOwnEmployeesByName($name);
    }
}
