<?php

namespace App\Providers;

use App\Facades\CustomLog;
use Illuminate\Support\ServiceProvider;

class LogProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('cdlog', function () {
            return new CustomLog;
        });
    }
}
