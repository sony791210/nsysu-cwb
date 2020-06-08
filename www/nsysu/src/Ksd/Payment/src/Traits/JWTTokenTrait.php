<?php
/**
 * User: lee
 * Date: 2019/05/29
 * Time: 上午 9:42
 */

namespace Ksd\Payment\Traits;

use Firebase\JWT\JWT;

trait JWTTokenTrait
{
    public function JWTencode($token, $key = '')
    {
        return JWT::encode($token, $key);
    }
}
