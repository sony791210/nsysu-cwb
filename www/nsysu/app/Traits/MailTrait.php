<?php
/**
 * User: lee
 * Date: 2019/02/25
 * Time: 上午 9:42
 */

namespace App\Traits;

use Mail;
use Exception;
use Log;

trait MailTrait
{
    /**
     * 寄信
     * @param string $subject
     * @param array $recipient
     * @param string $view
     * @param array $viewData
     * @return \App\Models\Member
     */
    public function send($subject, $recipient, $view, $viewData = [])
    {
        $from = [
            'address' => 'noreply@citypass.tw',
            'name' => 'CityPass都會通',
            'subject' => $subject ?: 'CityPass都會通 - 供應商平台 - 通知信'
        ];

        $to = [
            'email' => $recipient['email'],
            'name' => (isset($recipient['name'])) ? $recipient['name'] : ''
        ];

        try {
            Mail::send($view, $viewData, function ($message) use ($from, $to) {
                $message->from($from['address'], $from['name']);
                $message->sender($from['address'], $from['name']);
                $message->to($to['email'], $to['name'])->subject($from['subject']);
            });

            return true;
        } catch(Exception $e) {
            Log::error('smtp 有問題, 請檢查!');
            return false;
        }
    }
}
