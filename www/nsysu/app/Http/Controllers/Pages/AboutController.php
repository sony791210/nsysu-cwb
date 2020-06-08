<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;

class AboutController extends BaseController
{
    public function __construct()
    {

    }

    public function index()
    {

        return view('pages.app');
    }
}
