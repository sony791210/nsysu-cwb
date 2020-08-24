<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use PhpCsFixer\Finder;
use App\Module\Contact\ContactService;
class ContactController extends BaseController
{
    protected $service;

    public function __construct(ContactService $service)
    {
        $this->service=$service;
    }

    public function index()
    {

        return view('pages.app');
    }

    public function store(Request $request){
        
        try{
            $result=['name'=>$request->input('name'),
                    'phone'=>$request->input('phone'),
                    'subject'=>$request->input('subject'),
                    'content'=>$request->input('content'),
                    'email'=>($request->input('email'))?$request->input('email'):' '];
            $this->service->create($result);
            return $this->apiRespSuccess();
        }catch (\Exception $e){
            return $this->apiRespFail('E9999',$e->getMessage());
        }
        

    }//end store
}
