<?php

namespace Asciisd\ReferaralsLaravel\app\Providers;

use Illuminate\Support\ServiceProvider;
use function Asciisd\ReferaralsLaravel\Providers\config_path;

class ReferralsServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/referrals.php' => config_path('referrals.php'),
        ], 'referrals-config');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}