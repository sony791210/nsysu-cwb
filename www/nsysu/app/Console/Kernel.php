<?php

namespace App\Console;

use App\Console\Commands\UploadInvoice;
use App\Console\Commands\DownloadInvoice;
use App\Console\Commands\NotificationPush;

use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\CleanExpiredATMOrder;
use App\Console\Commands\NewsfeedNotification;
use App\Console\Commands\CleanExpiredDiningCar;
use App\Console\Commands\UploadDiningCarOrderAuthorize;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\AutoUpdateDiningcarBusinessStatus;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [

    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
