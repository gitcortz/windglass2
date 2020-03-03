<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Library\Services\Stocks\StocksService;

class StocksServiceProvider extends ServiceProvider
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
        $this->app->bind('App\Library\Services\Stocks\StocksServiceInterface', function ($app) {
            return new StocksService();
        });
    }
}
