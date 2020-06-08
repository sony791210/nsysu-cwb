<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Module\News\NewsService;
use Carbon\Carbon;

class HomeController extends BaseController
{
    protected $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    public function index()
    {

        return view('pages.app');
    }

    public function homeNews(Request $request)
    {
        try {
            $result = [];
            $result['list'] = $this->newsService->getNewsList()->map(function ($row) {
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
}
