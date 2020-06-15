<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Module\CWB\CWBFactory;
use App\Http\Requests\Api\RestLaravelController;

class CWBDataController extends RestLaravelController
{
    //
    

    public function getListInfo(Request $request)
    {
        dd('Q');
        return $this->success(CWBFactory::create('SSTInfo')->getListInfo());
    }
}
