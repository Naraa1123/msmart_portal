<?php

namespace App\Providers;

use App\Services\BylPaymentService;
use Illuminate\Support\ServiceProvider;

class BylPaymentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(BylPaymentService::class, function ($app) {
            return new BylPaymentService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
