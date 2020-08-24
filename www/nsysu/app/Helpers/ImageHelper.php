<?php
/**
 * User: lee
 * Date: 2019/01/02
 * Time: 上午 9:42
 */

namespace App\Helpers;

use App\Services\UrlService;

Class ImageHelper
{
    /**
     * 取單一照片
     *
     * @param $img
     * @param $size
     *
     * @return string
     */
    public static function url($img, $size = '')
    {
        if (!$img) return '';

        $filePath = '';

        $filePath = SELF::getFitImage($img, $size);

        return UrlService::getBackendDomain() . '/' . $filePath;
    }

    /**
     * 取所有照片
     *
     * @param $imgs
     * @param $size
     *
     * @return array
     */
    public static function urls($imgs, $size = '')
    {
        if ($imgs->isEmpty()) return [];

        $urls = [];
        foreach ($imgs as $img) {
            $urls[] = SELF::url($img, $size);
        }

        return $urls;
    }

    private static function getFitImage($img, $size = 'b')
    {
        $info = $img->compressed_info;

        if ($info && isset($info['compressed_sizes'][$size])) {
            $filePath = (env('USE_CDN_IMAGE', false)) ? $filePath = $info['image_hosting_urls'][$size] : sprintf('%s%s_%s.%s', $img['folder'], $img['filename'], $size, $img['ext']);
        } else {
            $filePath = sprintf('%s%s.%s', $img['folder'], $img['filename'], $img['ext']);
        }

        return $filePath;
    }

    /**
    * 文字轉QRCode
    * @param $text
    * @return string
    */
    public static function genQRcode($text = '')
    {
        return sprintf('%s%s', 'https://dev.ad.citypass.tw/chart/qrcode?text=', $text);
    }

    /**
    * 圖片轉換成Base64
    * @param $img 圖片
    * @param $ext 圖片格式
    * @return string
    */
    public static function toBase64($img = '', $ext = 'png')
    {
        if (!$img || !in_array($ext, ['png', 'jpg', 'jpeg'])) return '';

        $code = base64_encode(file_get_contents($img));

        return sprintf('data:image/%s;base64, %s', $ext, $code);
    }
}
