<?php

namespace App\Module\News;
use App\Module\News\NewsRepository;
use App\Module\News\NewsImgRepository;
use DB;
class NewsService
{
    protected $repository;
    protected $newsImgRepository;
    public function __construct(NewsRepository $repository,NewsImgRepository $newsImgRepository)
    {
        $this->repository = $repository;
        $this->newsImgRepository=$newsImgRepository;
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function updateOrCreate($params, $id = ''){
        
        DB::transaction(function () use ($params, $id) {
            
            $new_id = $this->repository->updateOrCreate(['id' => $id], $params['news'])->id;
            
            $this->newsImgRepository->uploadImg($new_id, $params['img']);
        });
    }//end create

    public function all()
    {
        return $this->repository->all();
    }//end all

    public function getList()
    {
        return $this->repository->getList();
    }

    public function getDetail($id)
    {
        return $this->repository->getDetail($id);
    }

    public function getNewsList()
    {
        return $this->repository->getNewsList();
    }















    public function active()
    {
        return $this->repository->list();
    }

    public function getEmployeeByCode($code)
    {
        return $this->repository->getEmployeeByCode($code);
    }

    public function getByIds($employeeLinks)
    {

        return $this->repository->getByIds($employeeLinks);
    }


}
