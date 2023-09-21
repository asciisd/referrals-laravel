<?php

namespace Ascii\ReferralsLaravel\Providers;

use Illuminate\Support\ServiceProvider;

class ReferralsServiceProvider
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
            __DIR__.'/../../config/referrals.php' => config_path('courier.php'),
        ]);
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
    }
}