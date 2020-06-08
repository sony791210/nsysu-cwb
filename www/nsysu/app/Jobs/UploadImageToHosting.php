<?php

namespace App\Jobs;

use App\Services\ImageHostings\SmugmugService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class UploadImageToHosting implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $img;

    /**
     * UploadImageToHosting constructor.
     * @param object $img  圖片物件
     */
    public function __construct($img)
    {
        $this->img = $img;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
            if ( ! optional($this->img)->id) {
                throw new \Exception('upload img to hosting no img id');
            }
            if ((new SmugmugService)->upload($this->img)) {
                Log::info('upload to img hosting success: img_id:' . optional($this->img)->id);
            } else {
                throw new \Exception('upload img to hosting fail');
            };
        }catch (\Exception $e){
            Log::error('img_id:' . optional($this->img)->id . ';message: ' . $e->getMessage());
        }
    }
}
