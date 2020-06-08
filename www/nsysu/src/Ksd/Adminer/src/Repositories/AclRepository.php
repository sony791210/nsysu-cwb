<?php
namespace Ksd\Adminer\Repositories;

use Ksd\Adminer\Models\Acl;

/**
 * 權限管理 Repository
 * Class AclRepository
 * @package Ksd\Adminer\Repositories
 */
class AclRepository
{
    protected $model;

    /**
     * AclRepository constructor.
     * @param Acl $model
     */
    public function __construct(Acl $model)
    {
        $this->model = $model;
    }

    /**
     * 根據ID查詢該筆權限資料
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * 使用權限名稱來查找
     * @param  string $name
     * @return \Ksd\Member\Models\Acl
     */
    public function findByName($name)
    {
        return $this->model->where('name', $name)->get()->first();
    }

    /**
     * 新增權限資料
     * @param $data
     * @return Acl
     */
    public function create($data)
    {
        $acl = new Acl;
        foreach ($data as $k => $v) {
            $acl->$k = $v;
        }
        $acl->save();
        return $acl;
    }

    /**
     * 更新權限資料
     * @param $id
     * @param $data
     * @return bool|mixed
     */
    public function update($id, $data)
    {
        $acl = $this->find($id);
        if (is_null($acl)) {
            return false;
        }
        foreach ($data as $k => $v) {
            $acl->$k = $v;
        }
        $acl->save();
        return $acl;
    }

    /**
     * 查出權限列表
     * @param int $page
     * @param int $limit
     * @return mixed
     */
    public function all($page = 1, $limit = 10)
    {
        $offset = ($page - 1) * $limit;
        return $this->model
            ->offset($offset)
            ->limit($limit)
            ->get();
    }

    /**
     * 依分類取得權限
     * @return Collection
     */
    public function getByCategory($categoryId)
    {
        return $this->model->where('category_id', $categoryId)->get();
    }

    /**
     * 資料不存在時新增反之則更新
     * @return \Ksd\Member\Models\Acl
     */
    public function put($attrs)
    {
        $acl = $this->findByName($attrs['name']);
        if (empty($acl)) {
            $acl = new Acl();
        }
        foreach ($attrs as $key => $val) {
            $acl->$key = $val;
        }
        $acl->save();
        return $acl;
    }
}
