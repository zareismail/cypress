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
        Cypress::boot();
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'cypress');

        $this->app->make(HttpKernel::class)
                    ->pushMiddleware(ServeCypress::class);
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
            Console\LayoutCommand::class, 
            Console\DisplayCommand::class, 
            Console\PluginCommand::class, 
        ]);
    }
}
