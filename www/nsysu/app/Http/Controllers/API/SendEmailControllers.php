<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\SendMailQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendEmailControllers extends Controller
{
    public function question(Request $request)
    {
        // 收件者務必使用 collect 指定二維陣列，每個項目務必包含 "name", "email"
        //TO 誰的email
        //from的設定再env
        //title 設定及設定再 SendMailQuestion
        //內文設定再 email.shipped  /resource/view/email/shipped
        $to = collect([
            ['name' => 'jerry', 'email' => trim('jerry.liu@touchcity.tw',"\r\n")]
        ]);
        // Ship order...
        Mail::to($to)->send(new SendMailQuestion());

    }


}
