<?php
/**
 * User: lee
 * Date: 2018/04/30
 * Time: 上午 9:42
 */

namespace App\Traits;

use Log;
use App\Exceptions\ErrorCode;

trait ApiResponseHelper
{
    private $successCode = '00000';

    public function apiRespSuccess($data = [])
    {
        return $this->apiRespDetail($this->successCode, 'success', $data);
    }

    public function apiRespFail($code, $message, $data = [])
    {
        return $this->apiRespDetail($code, $message, $data);
    }

    public function apiRespFailCode($code, $data = [])
    {
        return $this->apiRespDetail($code, ErrorCode::message($code), $data);
    }

    public function apiRespDetail($code, $message, $data = [])
    {
        $resp = ['code' => $code, 'message' => $message];
        if (!empty($data)) {
            $resp['data'] = $data;
        }

        return response()->json($resp, 200, [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
            'Access-Control-Allow-Headers' => 'X-Requested-With, Authorization, Content-Type, Accept'
        ]);
    }
}
