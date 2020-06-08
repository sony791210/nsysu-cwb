<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Module\News\NewsService;


use Validator;
use Hashids\Hashids;
use Carbon\Carbon;
class NewsController extends BaseController
{
    protected $service;
    protected $roleService;
    protected $employeeServ;

    public function __construct(NewsService $service)
    {
        $this->service = $service;
    }

    /**
     * 列表
     * @return
     */
    public function index()
    {
        $data['fields'] = collect([
            ['prop' => 'id','width' => '60px', 'label' => trans('admin/news.id')],
            ['prop' => 'title',  'label' => trans('admin/news.title')],
            ['prop' => 'img', 'width' => '250px', 'label' => trans('admin/news.img')],
            ['prop' => 'release_time', 'label' => trans('admin/news.datetime')],
            ['prop' => 'status','width' => '60px', 'label' => trans('admin/news.status')],
        ])->toJson();

        $data['list'] = $this->service->all()->map(function ($row) {
            
            return [
                'id' => $row->id,
                'title' => $row->title,
                'img' => $row->newsImg->small_img_url,
                'release_time' => Carbon::parse($row->datetime)->format('Y-m-d'),
                'status' => $row->status == 1 ? '啟用' : '停用',
                'editUrl' => route('news.edit', $row->id)
            ];
        })->toJson();

        return view('admin.news.index', $data);
    }
    public function create(Request $request){

        $newsData['image']=[];
        $newsData['isEdit']=false;
        $newsData['title']='';
        $newsData['release_time']=Carbon::now()->format('Y-m-d h:i');
        $newsData['status']='';
        $newsData['status']='';
        $newsData['content']='';
        $newsData['id']='';
        $newsData['urls']=$this->getUrls('create');
        $data=json_encode($newsData);
        
        // $data = $newsData->toJson();
        return view('admin.news.create', compact('data'));
    }//end create


    public function edit(Request $request, $id)
    {
        
        if (!$id)
            return redirect()->route('news.index');
        
        $newsData = $this->service->find($id);
        $newsData['image']=[['id' => $newsData->newsImg->id,'file' => '', 'url' => $newsData->newsImg->small_img_url, 'sort' => 1]];
        $newsData['isEdit']=true;
        $newsData['urls']=$this->getUrls('edit', $newsData->id);
        
        $data = $newsData->toJson();
        
        return view('admin.news.create', compact('data'));
    }


    private function getUrls($type, $newsfeed_id = '')
    {
        switch ($type) {
            case 'create':
                $urls['submitNewsfeed'] = route('news.store');
                break;

            default:
                $urls['submitNewsfeed'] = route('news.store');
                break;
        }
        $urls['index'] = route('news.index');
        
        return $urls;
    }//end getUrls


    


    public function store(Request $request){
        
        try{
           $this->service->updateOrCreate($request,$request['news']['id']);
            return $this->apiRespSuccess(); 
        } catch (\Exception $e) {
            return $this->apiRespFail('E0002' , $e->getMessage());
        }
    }//end store






    /**
     * 新增頁面
     * @return
     */
    public function new()
    {
        $data['role'] = $this->roleService->getAvailable(1, PHP_INT_MAX)->map(function ($row) {
            return [
                'key' => $row->id,
                'label' => $row->name . '(' . $row->description . ')'
            ];
        })->toJson();

        return view('admin.employee.new', $data);
    }


    // /**
    //  * 新增
    //  * @return
    //  */
    // public function create(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required',
    //         'displayName' => 'required',
    //         'email' => 'required|email',
    //         'password' => 'required|min:6|max:20',
    //         'checkPassword' => 'required|same:password'
    //     ]);

    //     if ($validator->fails()) {
    //         return $this->apiRespFailCode('E0002', join(' ', $validator->errors()->all()));
    //     }

    //     try {
    //         $data = [
    //             'name' => $request->input('name'),
    //             'displayName' => $request->input('displayName'),
    //             'email' => $request->input('email'),
    //             'password' => $request->input('password'),
    //             'status' => $request->input('status', false)
    //         ];
    //         //todo transaction

    //         $result = $this->employeeServ->add($data, $request->input('role', null));
    //         $hashids = new Hashids('crm', 10);
    //         $code = $hashids->encode($result->employee_id);
    //         $updateData = [
    //             'personal_code' => $code
    //         ];
    //         $this->employeeServ->update($result->employee_id, $updateData, $request->input('role', null));
    //         return $this->apiRespSuccess();
    //     } catch (\Exception $e) {
    //         dd($e);
    //         \Log::debug(print_r($e->getMessage(), true));
    //         return $this->apiRespFail('E0002', $e->getMessage());
    //     }
    // }

    /**
     * 編輯
     * @return
     */
    public function update(Request $request, $id)
    {
        try {
            $prop = [
                'displayName' => $request->input('displayName'),
                'email' => $request->input('email'),
                'status' => $request->input('status', false),
            ];

            if ($request->has('password') && $request->input('password')) {
                $prop['password'] = $request->input('password');
            }


            $result = $this->employeeServ->update($id, $prop, $request->input('role', []));

            return ($result) ? $this->apiRespSuccess() : $this->apiRespFailCode('E0003');
        } catch (\Exception $e) {
            return $this->apiRespFail('E0003', $e->getMessage());
        }
    }
}