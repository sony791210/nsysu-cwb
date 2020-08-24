<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Module\Contact\ContactService;

use Validator;
use Hashids\Hashids;
use Carbon\Carbon;
class ContactController extends BaseController
{
    protected $service;
    protected $roleService;
    protected $employeeServ;

    public function __construct(ContactService $service)
    {   
        $this->service=$service;
    }

    /**
     * 列表
     * @return
     */
    public function index()
    {
        $data['fields'] = collect([
            ['prop' => 'id','width' => '80px', 'label' => trans('admin/contact.id')],
            ['prop' => 'name','width' => '80px',  'label' => trans('admin/contact.name')],
            ['prop' => 'phone' ,'width' => '110px', 'label' => trans('admin/contact.phone')],
            ['prop' => 'subject','width' => '120px', 'label' => trans('admin/contact.subject')],
            ['prop' => 'content', 'label' => trans('admin/contact.content')],
            ['prop' => 'create','width' => '130px', 'label' => trans('admin/contact.create')],
        ])->toJson();

        $data['list'] = $this->service->all()->map(function ($row) {
            return [
                'id' => $row->id,
                'name' => $row->name,
                'phone' => $row->phone,
                'subject' => $row->subject,
                'content' => $row->content ,
                'create' => Carbon::parse($row->created_at)->format('Y-m-d H:i')
            ];
        })->toJson();
        return view('admin.contact.index',$data);
    }

}