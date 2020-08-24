<?php


namespace App\Module\News;

use App\Module\News\NewsImg;

use App\Module\UploadImageService;

use App\Module\BaseRepository;

class NewsImgRepository extends BaseRepository
{
    protected $model;

    public function __construct(NewsImg $model)
    {
        $this->model = $model;
    }
    
    public function uploadImg($news_id, $img)
    {
        if (empty($img['id'])) {
            $this->model->where('news_id', $news_id)->delete();
        } else {
            return true;
        }
        
        $folder = 'news/' . $news_id . '/';
        $file_name = md5($news_id . time());
        $image_service = new UploadImageService($folder);
        $img_info = $image_service->uploadImg($img['file'], $file_name);
        $update_data = array_merge($img_info, [
            'news_id' => $news_id
        ]);
        
        
        $this->model->updateOrCreate(
        [
            'news_id' => $news_id,
            'id' => $img['id']
        ], $update_data);
    }//end uploadImg


    
    

}
