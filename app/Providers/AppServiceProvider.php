<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $serviceMappings = collect(config('service-mapping.mapping'));
        $serviceMappings->each(function($mapping){
            $this->app->bind($mapping[0], $mapping[1]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
