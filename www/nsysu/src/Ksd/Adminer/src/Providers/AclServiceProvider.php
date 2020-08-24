<?php

namespace Ksd\Adminer\Providers;

use Illuminate\Support\ServiceProvider;
use Log;

class AclServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/acl.php', 'acl');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Adminer', function ($app) {
            return $app->make('Ksd\Adminer\Services\EmployeeService');
        });
    }
}
