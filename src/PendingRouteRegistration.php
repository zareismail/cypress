<?php

namespace Zareismail\Cypress;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Zareismail\Cypress\Events\CypressServiceProviderRegistered;

class PendingRouteRegistration
{
    /**
     * Indicates if the routes have been registered.
     *
     * @var bool
     */
    protected $registered = false;

    /**
     * Register the Cypress routes.
     *
     * @return void
     */
    public function register()
    {
        $this->registered = true; 

        if (app()->runningInConsole()) {
            app()->booted([$this, 'registerRoutes']);
        } else {
            Event::listen(CypressServiceProviderRegistered::class, [$this, 'registerRoutes']);
        } 
    }

    public function registerRoutes()
    {
        Route::namespace('Zareismail\Cypress\Http\Controllers')
            ->middleware(config('cypress.middleware', []))
            ->group(function($router) {
                $this->mapWebRoutes(); 
            }); 
            
        app('router')->getRoutes()->refreshNameLookups();
        app('router')->getRoutes()->refreshActionLookups();
    }

    /**
     * Register web routes.
     * 
     * @return void
     */
    public function mapWebRoutes()
    { 
        Cypress::componentCollection()->each(function($component) {
            Route::prefix($component::fallback() ? '/' : $component::uriKey())
                ->middleware($component::middlewares())
                ->group(function($router) use ($component) {
                    $router->get('/', 'ComponentController@handle')
                           ->name($component::uriKey().'.index');

                    $router->post('/widget/{widget}', 'WidgetController@handle')
                        ->name($component::uriKey().'.widget');  

                    $router->get('/{fragment}', 'FragmentController@handle')
                        ->name($component::uriKey().'.detail') 
                        ->where('fragment', '.*'); 
                });
        });
    } 

    /**
     * Handle the object's destruction and register the router route.
     *
     * @return void
     */
    public function __destruct()
    {
        if (! $this->registered) {
            $this->register();
        } 
    }
}
