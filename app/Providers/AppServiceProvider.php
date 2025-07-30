<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register DashboardCacheService as singleton
        $this->app->singleton(\App\Services\DashboardCacheService::class, function ($app) {
            return new \App\Services\DashboardCacheService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set Carbon locale to Indonesian
        Carbon::setLocale('id');
        
        // Set default timezone
        date_default_timezone_set('Asia/Jakarta');
    }
}
