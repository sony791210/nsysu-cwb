<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;

class TrafficController extends BaseController
{
    public function __construct()
    {

    }

    public function index()
    {

        return view('pages.app');
    }
}
