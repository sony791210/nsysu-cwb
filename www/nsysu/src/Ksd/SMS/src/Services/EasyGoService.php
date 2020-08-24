<?php

namespace Ksd\SMS\Services;

use Validator;
use Log;
use Config;

use Ksd\SMS\Contracts\SMSSender;

class EasyGoService implements SMSSender
{
    const MODE_IMMEDIATE = 'Immediate';
    const MODE_RESERVATION = 'Reservation';

    private $mode = self::MODE_IMMEDIATE;
    private $longFlag = 'false';
    private $activateDatetime = '';
    private $smsExpireTime = '';

    /**
    * 設置模式 立即發送(Immediate) | 預約發送(Reservation)
    * @param string $mode
    * @return void
    */
    public function setMode($mode)
    {
        $this->mode = $mode;

        return $this;
    }

    /**
    * 設置是否為長簡訊 true | false
    * @param boolean $longFlag
    * @return void
    */
    public function setLongFlag($longFlag = false)
    {
        $this->longFlag = ($longFlag) ? 'true' : 'false';

        return $this;
    }

    public function send($phoneNumber, $message)
    {
        $data = [
            'UserName'         => config('sms.providers.easygo.username'),
            'Password'         => config('sms.providers.easygo.password'),
            'Cellno'           => $phoneNumber,
            'MsgBody'          => $message,
            'Mode'             => $this->mode,
            'LongFlag'         => $this->longFlag,
            'ActivateDateTime' => $this->activateDatetime,
            'SMSExpireTime'    => $this->smsExpireTime,
        ];

        if (config('sms.status') == false)
            return true;

        Log::debug("-==發送EasyGo簡訊==-");
        Log::debug("$phoneNumber, $message");
        Log::debug(print_r($data, true));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config('sms.providers.easygo.url') . '/CallSendSMS');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, config('sms.api_timeout'));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

        $result = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        Log::debug("{$status} {$result}");
        curl_close($ch);
        return $result;
    }
}
