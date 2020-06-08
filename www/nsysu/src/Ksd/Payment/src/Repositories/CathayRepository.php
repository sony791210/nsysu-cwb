<?php
/**
 * User: Lee
 * Date: 2018/11/26
 * Time: 下午2:20
 */

namespace Ksd\Payment\Repositories;

use Ksd\Payment\Models\Client;
use Exception;
use Log;


class CathayRepository extends Client
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 自動扣款建立訂單
     * @param $parameters
     * @return mixed
     */
    public function createPeriodOrder($parameters)
    {
        try {
            $response = $this->putParameters($parameters)
                ->request('POST', 'v1/creditCard/createPeriodOrder');

            $result = json_decode($response->getBody(), true);

            return $result;
        } catch (ClientException $e) {
            Log::debug('=== credit card createPeriodOrder error ===');
            Log::debug(print_r($e->getMessage(), true));
            return false;
        } catch (Exception $e) {
            Log::debug('=== credit card createPeriodOrder unknown error ===');
            Log::debug(print_r($e->getMessage(), true));
            return false;
        }
    }

    /**
     * 自動扣款
     * @param $parameters
     * @return mixed
     */
    public function preapprovedPay($parameters)
    {
        try {
            $response = $this->putParameters($parameters)
                ->request('POST', 'v1/creditCard/preapprovedPay');

            $result = json_decode($response->getBody(), true);

            return $result;
        } catch (ClientException $e) {
            Log::debug('=== credit card preapprovedPay error ===');
            Log::debug(print_r($e->getMessage(), true));
            return false;
        } catch (Exception $e) {
            Log::debug('=== credit card preapprovedPay unknown error ===');
            Log::debug(print_r($e->getMessage(), true));
            return false;
        }
    }
}
