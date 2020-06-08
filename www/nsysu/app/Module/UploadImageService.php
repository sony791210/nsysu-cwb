<?php
namespace App\Module;

use App\Jobs\UploadImageToHosting;
use Storage;
use Image;

class UploadImageService
{
    // storage圖片儲存的路徑, 含最後分隔號 ex. folder/id/
    protected $folder;
    
    // 使用圖片時的路徑
    protected $link_folder;

    // 指定壓縮格式與檔名後綴 [tag => size , ......], 預設會壓縮成三種大小
    protected $compressed_info;
    
    protected $image_hosting_urls;

    protected $is_upload_to_hosting;
    
    public function __construct($folder = '')
    {
        $this->setFolders($folder);
        $this->compressed_info = ['b' => 1920, 'm' => 960, 's' => 480];
        $this->is_upload_to_hosting = config('hosting.upload_to_hosting');
    }
    
    public function setFolders($folder)
    {
        $this->folder = $folder;
        $this->link_folder = 'storage/' . $folder;
    }
    
    public function setIsUploadtoHosting(bool $is_upload_to_hosting)
    {
        $this->is_upload_to_hosting = $is_upload_to_hosting;
    }
    
    public function setCompressedInfo(array $compressed_info)
    {
        $this->compressed_info = $compressed_info;
    }

    /**
     * 上傳並壓縮檔案為各種尺寸
     * @param file $file 圖片檔案
     * @param string $file_name 檔名
     * @param bool $add_watermark 是否添加浮水印
     * @return array
     * @throws \Exception
     */
    public function uploadImg($file, $file_name, $add_watermark = false)
    {
        $image = Image::make($file);
        $extension = $file->getClientOriginalExtension();
        $file_path = $this->folder . $file_name . '%s' . '.' . $extension;
        

        $result = Storage::disk('public')->put(sprintf($file_path, ''), $image->encode($extension));
        
        $image_hosting_urls['origin'] = '';
        $this->checkImageUpload($result);
        foreach ($this->compressed_info as $tag => $size) {
            $this_file_path = sprintf($file_path, '_' . $tag);
            $processed_img = $image->resize($size, null, function ($constraint) {
                                $constraint->aspectRatio();
                             });
            // // 加入浮水印
            // if ($add_watermark) {
            //     $processed_img = $processed_img->insert(
            //                         Image::make(public_path('watermark.png'))
            //                             ->resize((int)($size/3.5), null, function ($constraint) {
            //                                 $constraint->aspectRatio();
            //                             }), 'bottom-right', (int)($size/96), (int)($size/96)
            //                      );
            // }
            $result = Storage::disk('public')->put($this_file_path, $processed_img->encode($extension));
            $this->checkImageUpload($result);
            $image_hosting_urls[$tag] = '';
        }
        
        return $this->getImgInfo($file, $file_name, $image_hosting_urls);
    }
    
    protected function getImgInfo($file, $file_name, $image_hosting_urls) : array
    {
        list($width, $height) = getimagesize($file);
        $size = filesize($file);
        $origin_name = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $compressed_info = [
            'compressed_sizes' => $this->compressed_info, 
            'image_hosting_urls' => $image_hosting_urls
        ];
        
        return [
            'folder' => $this->link_folder,
            'filename' => $file_name,
            'origin_name' => $origin_name,
            'ext' => $extension,
            'width' => $width,
            'height' => $height,
            'size' => $size,
            'compressed_info' => $compressed_info,
        ];
    }

    /**
     * 上傳至雲端
     * @param object $img image物件
     */
    public function uploadToHosting($img)
    {
        if ( ! $this->is_upload_to_hosting) return false;
        $job = (new UploadImageToHosting($img))->onQueue('uploadImage')->delay(20);
        dispatch($job);
    }
    
    private function checkImageUpload(bool $result)
    {
        if ($result === false) throw new \Exception('upload image fail');
    }
}
