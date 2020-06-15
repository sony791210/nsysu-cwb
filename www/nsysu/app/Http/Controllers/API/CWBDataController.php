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
        
        return $this->success(CWBFactory::create('SST')->getListInfo());
    }
}
