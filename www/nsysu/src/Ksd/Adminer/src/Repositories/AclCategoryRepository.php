<?php

namespace Ksd\Adminer\Repositories;

use Ksd\Adminer\Models\AclCategory;
use Log;

class AclCategoryRepository
{
    protected $model;

    public function __construct(AclCategory $model)
    {
        $this->model = $model;
    }

    /**
     * 取得所有分類
     * @return Collection
     */
    public function get()
    {
        return $this->model->get();
    }

    /**
     * 查找單一分類
     * @return \Ksd\Member\Models\AclCategory
     */
    public function findByName($name)
    {
        return $this->model->where('name', $name)->get()->first();
    }

    /**
     * 資料不存在時新增，存在時進行更新
     * @return \Ksd\Member\Models\AclCategory
     */
    public function put($attrs)
    {
        $category = $this->findByName($attrs['name']);
        if (empty($category)) {
            $category = new AclCategory();
        }
        foreach ($attrs as $key => $val) {
            $category->$key = $val;
        }
        $category->save();
        return $category;
    }
}
