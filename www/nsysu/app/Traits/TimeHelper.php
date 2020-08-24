<?php
/**
 * User: Annie
 * Date: 2019/09/02
 * Time: 上午 10:19
 */

namespace App\Traits;

use Carbon\Carbon;

trait TimeHelper
{
    
    /**
     * isBeteenTime 檢查是否在起始時間與結束時間內 (不檢查日期)
     *
     * @param  mixed $startTime
     * @param  mixed $endTime
     *
     * @return void
     */
    public function isBeteenTime($startTime,$endTime){
        $now = Carbon::now();        
        $start = Carbon::create($now->year, $now->month, $now->day, date("H", $startTime), date("i", $startTime), 0); 
        $end = Carbon::create($now->year, $now->month, $now->day, date("H", $endTime), date("i", $endTime), 0); //set time to 18:00
        if ($now->between($start, $end, true)) {
            return true;
        } else {
            return false;
        }
        
    }
     
}
