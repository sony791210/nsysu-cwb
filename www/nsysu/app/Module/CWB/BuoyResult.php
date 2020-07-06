<?php
namespace App\Module\CWB;


use Carbon\Carbon;
class BuoyResult
{

    // protected $speedName=['0-2','2 - 5','5-7','7-10','10-15','15-20','20+'];
    protected $windSpeedName=['0 - 2','2 - 5','5 - 7','7 - 10','10 - 15','15 - 20','20+'];
    protected $waveSpeedName=['0 - .05','.05 - 0.5','0.5 - 1','1 - 2','2 - 5','5+'];
    protected $spdRange;

    public function __construct ()
    {   
        $sep=10;
        for( $i=0 ; $i<=360/$sep ; $i++ ) {
            $this->spdRange[]=$i*$sep;            
        }
        
        
    }


    public function preTreatment($data,$number){
        $dataGroupByOBS=collect($data)->groupBy('obs_time');
        
        foreach($dataGroupByOBS as $time=>$item){
            $result[]=['spd'=>($item[0]->value)?$item[0]->value/$number:'',
                      'dir'=>$item[1]->value,
                      'obs'=>$time,
                      'station_id'=>$item[0]->station_id];
        }
        return $result;
    }


    public function windRose($data){
        $data=$this->preTreatment($data,10);
        $arraySpd=[2,5,7,10,15,20];
        return $this->result($data,$arraySpd,$this->windSpeedName);
    }//windpre


    public function waveRose($data){
        $data=$this->preTreatment($data,100);
             // 0  1 2 3  4  5   6 
        $arraySpd=[0.05,0.5,1,2,5];
        return $this->result($data,$arraySpd,$this->waveSpeedName);
    }//windpre

    public function result($data,$arraySpd,$speedName){
        $allcount=collect($data)->count();
        $arrayDir=[];
        for( $i=0 ; $i<16 ; $i++ ) {
            $arrayDir[]=$i*22.5+11.25;            
        }
        $arrayDir[]=360;
        
         

        $noWindCount=0;
        foreach($data as $item){
            $newWind=new \stdclass;
            if(empty($item['spd'])){
                $noWindCount+=1;
                continue;
            }
            foreach($arrayDir as $keyDir=>$dir){
                
                if($item['dir']<=$dir){
                    
                    if($keyDir==16){
                        $ct=0;
                        $newWind->dirArea=$ct;
                        $newWind->angle=$this->changValue($item['dir']);
                        continue;
                    }else{
                        $ct=$keyDir;
                        $newWind->dirArea=$ct;
                        $newWind->angle=$this->changValue($item['dir']);
                        break;
                    }
                    
                }
            }//end arrayDir
            

            foreach($arraySpd as $keySpd=>$spd){
                if($item['spd']<=$spd){
                    $newWind->spdArea=$keySpd;
                    // $newWind->spd=$item['spd'];
                    break;
                }else{
                    $newWind->spdArea=$keySpd;
                    // $newWind->spd=$item['spd'];
                }
                
            }//end arraySpd
            $result[]=$newWind;
        }//end data
        // $allcount
        
        $dataGroup=collect($result)->groupBy(['spdArea','dirArea']);
        
        foreach($dataGroup as $key1=>$spdGroup){

            foreach($spdGroup as $key2=>$dirGroup){
                    
                $count=collect($dirGroup)->count();
                foreach($dirGroup as $item){
                    $finalResult[]=['angle'=>$item->angle,
                                    'speed'=>$speedName[$item->spdArea],
                                    'percent'=>($count/$allcount),
                                    'sort'=>$item->spdArea];
                }

            }
        }

        // $result=[];
        // $dataGroup2=collect($finalResult)->groupBy(['angle','sort']);
        // foreach($dataGroup2 as $key1=>$spdGroup){

        //     foreach($spdGroup as $key2=>$dirGroup){
                
        //         $result[]=$dirGroup[0];
                
        //     }
        // }
        
        

    
        return collect($finalResult)->sortBy('sort')->values()->all();
    }

    public function changValue($data){
        // return $data;

        $result=collect($this->spdRange)->filter(function ($item) use($data) {
            return $item > $data;   
        });
        
        return $result->first();

    }





}