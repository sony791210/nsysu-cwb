<?php

namespace App\Traits;

Trait ResultHelper
{
    
    /**
     * 將資料轉換為選項們
     * @param array $data                       傳入資料
     * @param array $option_and_column_key      ['option_key' => 'column_key']
     * @return array
     */
    protected function getOptions($data, $option_and_column_key = ['value' => 'id', 'lable' => 'name']) : array
    {
        $options = [];
        foreach ($data as $val)
        {
            $option = [];
            foreach ($option_and_column_key as $option_key => $column_key) {
                $option[$option_key] =  $val->{$column_key};
            }
            $options[] =  $option;
        }
        return $options;
    }
    
    protected function getStatusOptions()
    {
        return [
                    ['value' => 1, 'label' => '啟用'],
                    ['value' => 0, 'label' => '停用'],
                ];
    }
    
    protected function getImgs($img_data)
    {
        $imgs = [];
        foreach ($img_data as $img) {
            $imgs[] = [
                'id' => $img->id,
                'url' => $img->small_img_url,
                'sort' => $img->sort,
                'uid' => $img->filename
            ];
        }
        return $imgs;
    }
}
