<?php

namespace Ksd\SMS\Providers;

use Illuminate\Support\ServiceProvider;

class SMSServiceProvider extends ServiceProvider
{
    private $providers = [
        'easygo' => 'Ksd\SMS\Services\EasyGoService'
    ];
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/sms.php' => config_path('sms.php'),
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Ksd\SMS\Contracts\SMSSender', function($app) {
            return $app->make($this->providers[
                config('sms.default')
            ]);
        });
    }
}
