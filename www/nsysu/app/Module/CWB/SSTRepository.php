<?php
namespace App\Module\CWB;

use App\Module\CWB\SST;
use App\Module\CWB\SSTInfo;
class SSTRepository
{
    protected $sstmodel;
    protected $sstInfomodel;
    /*
    *    將需要使用的Model通過建構函式例項化
    */
    public function __construct (SST $sstmodel,
                                SSTInfo $sstInfomodel)
    {   
        $this->sstmodel=$sstmodel;
        $this->sstInfomodel=$sstInfomodel;
    }


    public function getListInfo(){
        $this->sstInfomodel->all();
    }
}