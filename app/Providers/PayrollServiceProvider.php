<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Library\Services\Payroll\PayrollService;

class PayrollServiceProvider extends ServiceProvider
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
        
        $this->app->bind('App\Library\Services\Payroll\PayrollServiceInterface', function ($app) {
            return new PayrollService();
        });
    }
}
