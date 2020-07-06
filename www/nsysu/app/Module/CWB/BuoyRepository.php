<?php
namespace App\Module\CWB;

use App\Module\CWB\Buoy;
use App\Module\CWB\BuoyInfo;

use Carbon\Carbon;
use Mockery\Generator\StringManipulation\Pass\Pass;
use App\Module\CWB\BuoyResult;
class BuoyRepository
{
    protected $buoymodel;
    protected $buoyInfomodel;
    /*
    *    將需要使用的Model通過建構函式例項化
    */
    public function __construct ()
    {   
        $this->buoymodel=new Buoy();
        $this->buoyInfomodel=new BuoyInfo();
        
    }

    

    public function getListInfo(){
        return $this->buoyInfomodel->all();
    }

    public function getDetailDataWind($stationId,$time){
        
        $data=$this->buoymodel->where('station_id',$stationId)->whereIn('types',['1','2'])->orderBy('obs_time','asc')->get();
        
        if(empty($data[0])){
            $result='';
        }else{
            $result=(new BuoyResult)->windRose($data);
        }

        return $result;
    }

    public function getDetailDataWave($stationId,$time){
        
        $data=$this->buoymodel->where('station_id',$stationId)->whereIn('types',['6','8'])->orderBy('obs_time','asc')->get();
        
        
       
        if(empty($data[0])){
            $result='';
        }else{
            $result=(new BuoyResult)->waveRose($data);
        }

        return $result;
    }

    public function getDetailDataSST($stationId,$time){
        
        $data=$this->buoymodel->where('station_id',$stationId)->whereIn('types',['5'])->orderBy('obs_time','asc')->get();
        
        $result=[];
        foreach($data as $item){
            $tmp=new \stdClass;
            $tmp->date=$item->obs_time;
            $tmp->visits=$item->value/10;
            $result[]=$tmp;
        }

        return $result;
    }
}