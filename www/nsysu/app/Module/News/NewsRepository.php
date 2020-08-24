<?php

namespace App\Module\News;

use App\Module\News\News;
use App\Module\BaseRepository;

class NewsRepository extends BaseRepository
{
    protected $model;

    public function __construct(News $news)
    {
        $this->model = $news;
    }

    /**
     * get employee's data form citypass backend by id
     *
     * @param integer $id
     * @return App\Models\Backend\Employee
     */
    public function find($id)
    {
        return $this->model->with(['newsImg'])->find($id);
        
    }

    //資訊更新
    public function updateOrCreate($id,$params){
        
        return $this->model->updateOrCreate($id,$params);
    }

    //取的全部資訊
    public function all()
    {
        return $this->model->with(['newsImg'])->orderBy('release_time','DESC')->get();
    }

    //取前端列表(狀態開啟)
    public function getList()
    {
        return $this->model->with(['newsImg'])->orderBy('release_time')->where('status', 1)->get();
    }

    //取前端列表(狀態開啟)
    public function getDetail($id)
    {
        return $this->model->with(['newsImg'])->where('id', $id)->where('status', 1)->first();
    }

    //取前端列表(狀態開啟)
    public function getNewsList()
    {
        return $this->model->with(['newsImg'])->orderBy('release_time')->where('status', 1)->limit(3)->get();
    }












    public function getEmployeeByCode($code)
    {
        return $this->model
            ->where('personal_code', $code)
            ->where('status', 1)
            ->first();
    }

    public function list()
    {
        return $this->model->active()->get();
    }

    public function getByIds($ids)
    {

        return $this->model->whereIn('employee_id', $ids)->get();
    }

}
