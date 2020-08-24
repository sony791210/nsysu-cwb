<?php

namespace Ksd\SMS\Contracts;

interface SMSSender
{
    public function send($phoneNumber, $message);
}
