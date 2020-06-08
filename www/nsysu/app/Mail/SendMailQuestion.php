<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailQuestion extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {     
        //subject 為主旨
        //相關變數如with帶走
        //內文設定再 email.shipped  /resource/view/email/shipped
        return $this->view('email.shipped')
                    ->subject('shippednotification')
                    ->with([
                        'orderName' => 'hu',
                        'orderPrice' => '100',
                    ]);
    }
}
