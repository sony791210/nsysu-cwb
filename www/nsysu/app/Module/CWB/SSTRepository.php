<?php
namespace App\Module\CWB;

use App\Module\CWB\SST;
use App\Module\CWB\SSTInfo;
use Carbon\Carbon;
class SSTRepository
{
    protected $sstmodel;
    protected $sstInfomodel;
    /*
    *    將需要使用的Model通過建構函式例項化
    */
    public function __construct ()
    {   
        $this->sstmodel=new SST();
        $this->sstInfomodel=new SSTInfo();
    }


    public function getListInfo(){
        return $this->sstInfomodel->all();
    }

    public function getDetailData($stationId,$time){
        
        return $this->sstmodel->where('station_id',$stationId)
                    ->where(function($query) use($time){
                        if($time==0){

                        }else{
                            // $query->whereTime('obs_time', '>=', Carbon::today()->subMonths($time));
                            $query->where('obs_time', '>=', Carbon::today()->subMonths($time));
                        }
                        
                    })
                    ->orderBy('obs_time','asc')->get();
    }
}