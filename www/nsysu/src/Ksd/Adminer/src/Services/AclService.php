<?php
namespace Ksd\Adminer\Services;

use Ksd\Adminer\Repositories\AclRepository;
use Ksd\Adminer\Repositories\AclCategoryRepository;

/**
 * 權限管理 Service
 * Class AclService
 * @package Ksd\Adminer\Services
 */
class AclService
{
    protected $aclRepo;
    protected $aclCategoryRepo;

    /**
     * AclService constructor.
     * @param AclRepository         $aclRepo
     * @param AclCategoryRepository $aclCategoryRepo
     */
    public function __construct(AclRepository $aclRepo, AclCategoryRepository $aclCategoryRepo)
    {
        $this->aclRepo = $aclRepo;
        $this->aclCategoryRepo = $aclCategoryRepo;
    }

    /**
     * 根據ID查詢該筆權限資料
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->aclRepo->find($id);
    }

    /**
     * 新增權限資料
     * @param $data
     * @return \Ksd\Member\Models\Acl
     */
    public function create($data)
    {
        return $this->aclRepo->create($data);
    }

    /**
     * 更新權限資料
     * @param $id
     * @param $data
     * @return bool|mixed
     */
    public function update($id, $data)
    {
        return $this->aclRepo->update($id, $data);
    }

    /**
     * 查出權限列表
     * @param int $page
     * @param int $limit
     * @return mixed
     */
    public function all($page = 1, $limit = 10)
    {
        return $this->aclRepo->all($page, $limit);
    }
}
