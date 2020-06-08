<?php

namespace App\Module\Contact;


class ContactRepository
{
    protected $model;

    public function __construct(Contact $contact)
    {
        $this->model = $contact;
    }

    public function create($data){
        $this->model->create($data);
    }

    public function all(){
        return $this->model->orderBy('created_at','DESC')->get();
    }

}
