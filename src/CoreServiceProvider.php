<?php

namespace Zareismail\Cypress;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider; 
use Illuminate\Contracts\Http\Kernel as HttpKernel; 
use Zareismail\Cypress\Http\Middleware\ServeCypress;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'cypress');

        $this->app->make(HttpKernel::class)
                    ->pushMiddleware(ServeCypress::class);

        $this->app->booted(function() {
            return $this->routes();
        });
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        $this->app->routesAreCached() || Cypress::routes(); 
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([ 
            Console\ComponentCommand::class, 
            Console\FragmentCommand::class, 
            Console\WidgetCommand::class, 
        ]);
    }
}
