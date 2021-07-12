<?php

namespace Zareismail\Cypress\Tests;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider; 

class ServiceProvider extends LaravelServiceProvider
{ 
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/resources/views', 'cypress-test');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }
}