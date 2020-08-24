<?php

namespace App\Module\Contact;

class ContactService
{
    protected $repository;

    public function __construct(ContactRepository $repository)
    {
        $this->repository = $repository;
    }

    //前端儲存資料
    public function create($data){
       return $this->repository->create($data);
    }


    //後台拿資料
    public function all(){

        return $this->repository->all();
    }


}
