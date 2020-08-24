<?php

namespace App\Traits;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Request;

trait JWTTokenHelper
{
    public function JWTencode($token)
    {
      return JWT::encode($token, env('JWT_KEY'));
    }

    public function JWTdecode($token = null)
    {
        if (!$token) $token = Request::bearerToken();

        if (!$token) return null;

        try {
            return JWT::decode($token, env('JWT_KEY'), ['HS256']);
        } catch (\Firebase\JWT\ExpiredException $exception) {
            return null;
        } catch (\Firebase\JWT\SignatureInvalidException $exception) {
            return null;
        } catch (\Exception $exception) {
            return null;
        }

        return null;
    }

}
