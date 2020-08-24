<?php

namespace App\Module;

use App\Module\Base;

class ImageBase extends Base
{
    const TAGS = [
        'small' => 's',
        'medium' => 'm',
        'big'   => 'b',
    ];
    
    const COMPRESSED_INFO_KEYS = ['compressed_sizes', 'image_hosting_urls'];
 
    protected $guarded = ['id'];

    protected $casts = ['compressed_info' => 'array'];
    
//    protected $appends = ['small_img_url', 'medium_img_url', 'big_img_url'];
    
    protected $use_image_hosting_url = true;
    
    /*
     * 取得小圖網址, 如不存在取得原圖網址
     */
    public function getSmallImgUrlAttribute()
    {
        return $this->getImgUrl('small');
    }
    
    /*
     * 取得中圖網址, 如不存在取得原圖網址
     */
    public function getMediumImgUrlAttribute()
    {
        return $this->getImgUrl('medium');
    }
    
    /*
     * 取得大圖網址, 如不存在取得原圖網址
     */
    public function getBigImgUrlAttribute()
    {
        return $this->getImgUrl('big');
    }
    
    /**
     * 先取圖床網址,不存在的話取本地網址
     * @param string $size
     * @return string
     */
    private function getImgUrl($size)
    {
        if ( ! empty($this->compressed_info['image_hosting_urls'][self::TAGS[$size]]) &&
             $this->use_image_hosting_url
        ) {
            $url = $this->compressed_info['image_hosting_urls'][self::TAGS[$size]];
        } else {
            $url = $this->getLocalUrl($size);
        }
        return $url;
    }

    // 未取得指定size時返回原圖url
    private function getLocalUrl($size)
    {
        if (isset(self::TAGS[$size])) {
            return asset($this->folder . $this->filename . '_' . self::TAGS[$size] . '.' . $this->ext);
        }
        return asset($this->folder . $this->filename . '.' . $this->ext);
    }
}
