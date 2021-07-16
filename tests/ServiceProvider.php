<?php

namespace Zareismail\Cypress\Tests;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider; 
use Zareismail\Cypress\Cypress;

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
        $this->registerCypressComponents();
    }

    /**
     * Register the cypress component classes.
     * 
     * @return void
     */
    protected function registerCypressComponents()
    { 
        Cypress::components([
            Fixtures\Blog::class, 
            Fixtures\Home::class,
        ]);
    }
}