<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Module\CWB\CWBFactory;
use App\Http\Requests\Api\RestLaravelController;

class CWBDataController extends RestLaravelController
{
    //
    

    public function getListInfo(Request $request,$name)
    {
        
        $data=CWBFactory::create($name)->getListInfo();
         
        $result=[];
        foreach($data as $item){
            
            $item->local=[0=>$item->lat,1=>$item->lon];
            $item->name=$item->station_name;
            $result[]=$item;
        }
        return $this->success($result);
    }

    public function getDetailData(Request $request,$name)
    {
        $stationId=$request->query('stationId');
        $time=$request->query('time');
        
        $data=CWBFactory::create($name)->getDetailData($stationId,$time);
         
        $result=[];
        foreach($data as $item){
            $tmp=new \stdClass;
            $tmp->date=$item->obs_time;
            $tmp->visits=$item->value;
            $result[]=$tmp;
        }
        return $this->success($result);
    }

    
}
