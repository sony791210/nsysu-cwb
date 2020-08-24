<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Module\News\NewsService;
use Carbon\Carbon;

class NewsController extends BaseController
{
    protected $service;

    public function __construct(NewsService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('pages.app');
    }

    public function detail(Request $request, $id)
    {

        return view('pages.app');
    }

    public function list(Request $request)
    {
        try {
            $result = [];
            $result['list'] = $this->service->getList()->map(function ($row) {
                return [
                    'id' => $row->id,
                    'title' => $row->title,
                    'img' => $row->newsImg->small_img_url,
                    'desc' => strip_tags($row->content),
                    'release_time' => Carbon::parse($row->datetime)->format('Y/m/d')
                ];
            });

            return $this->apiRespSuccess($result);
        } catch (\Exception $e) {
            return $this->apiRespFail('E9999',$e->getMessage());
        }
    }

    public function getDetail(Request $request, $id)
    {
        try {
            $data = $this->service->getDetail($id);

            $result = new \stdClass();
            $result->id = $data->id;
            $result->title = $data->title;
            $result->img = $data->newsImg->small_img_url;
            $result->desc = $data->content;
            $result->release_time = Carbon::parse($data->datetime)->format('Y/m/d');

            return $this->apiRespSuccess($result);
        } catch (\Exception $e) {
            return $this->apiRespFail('E9999',$e->getMessage());
        }
    }
}
