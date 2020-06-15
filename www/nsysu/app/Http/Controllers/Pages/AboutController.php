<?php

namespace App\Http\Controllers\Pages;



class AboutController extends BaseController
{
    public function __construct()
    {

    }

    public function index()
    {
        return view('pages.app');
    }

    public function tideIndex()
    {
        return view('pages.app');
    }


}
