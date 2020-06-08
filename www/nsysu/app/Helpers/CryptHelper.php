<?php
/**
 * User: lee
 * Date: 2019/02/25
 * Time: 上午 9:42
 */

namespace App\Helpers;

use Illuminate\Encryption\Encrypter;

trait CryptHelper
{
    /**
     * 編碼
     * @param string $plainTextToEncrypt
     * @param string $key
     * @return string
     */
    public static function encrypt($plainTextToEncrypt = '', $key = ''): String
    {
        if (!$key) $key = env('APP_KEY');

        return SELF::customEncrypt($key, $plainTextToEncrypt);
    }

    /**
     * 解碼
     * @param string $encrypted
     * @param string $key
     * @return string
     */
    public static function decrypt($encrypted = '', $key = ''): String
    {
        if (!$key) $key = env('APP_KEY');

        return SELF::customDecrypt($key, $encrypted);
    }

    /**
     * 可自訂定key編碼
     * @param string $key
     * @param string $plainTextToEncrypt
     * @return string
     */
    public static function customEncrypt($key = '', $plainTextToEncrypt = ''): String
    {
        $newEncrypter = new Encrypter($key, config('app.cipher'));
        return $newEncrypter->encrypt($plainTextToEncrypt);
    }

    /**
     * 可自訂定key解碼
     * @param string $key
     * @param string $encrypted
     * @return string
     */
    public static function customDecrypt($key = '', $encrypted = ''): String
    {
        $newEncrypter = new Encrypter($key, config('app.cipher'));
        return $newEncrypter->decrypt($encrypted);
    }
}
