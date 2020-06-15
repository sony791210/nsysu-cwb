<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Module\CWB\CWBFactory;
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

    public function getlist(Request $request){

        return CWBFactory::create('SSTInfo')->getlist();
    }
}
