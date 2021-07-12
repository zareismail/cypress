<?php

namespace Zareismail\Cypress; 

use Illuminate\Http\Request;

class Cypress
{   
    /**
     * The registered component names.
     *
     * @var array
     */
    public static $components = [];

    /**
     * Get the current Cypress version.
     *
     * @return string
     */
    public static function version()
    {
        return '1.0.0';
    }

    /**
     * Get the app name utilized by Cypress.
     *
     * @return string
     */
    public static function name()
    {
        return config('dcypress.name', 'Cypress Site');
    } 

    /**
     * Get the application host name.
     *
     * @return string
     */
    public static function host()
    {
        return config('cypress.host');
    }

    /**
     * Register the Cypress routes.
     *
     * @return \Zareismail\Cypress\PendingRouteRegistration
     */
    public static function routes()
    { 
        return new PendingRouteRegistration;
    }

    /**
     * Register an event listener for the Cypress "serving" event.
     *
     * @param  \Closure|string  $callback
     * @return void
     */
    public static function serving($callback)
    {
        Event::listen(ServingCypress::class, $callback);
    }

    /**
     * Register the given components.
     *
     * @param  array  $components
     * @return static
     */
    public static function components(array $components)
    {
        static::$components = array_unique(
            array_merge(static::$components, $components)
        );

        return new static;
    } 

    /**
     * Replace the registered components with the given components.
     *
     * @param  array  $components
     * @return static
     */
    public static function replaceComponents(array $components)
    {
        static::$components = $components;

        return new static;
    }

    /**
     * Return the base collection of Cypress components.
     *
     * @return \Zareismail\Cypress\ComponentCollection
     */
    public static function componentCollection()
    {
        return Collections\ComponentCollection::make(static::$components);
    } 

    /**
     * Get the components available for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public static function availableComponents(Request $request)
    {
        return static::componentCollection()->all();
    }

    /**
     * Get the component class name for a given key.
     *
     * @param  string  $key
     * @return string
     */
    public static function componentForKey(string $key = null)
    { 
        return static::componentCollection()->find(trim($key, '/'));
    }

    /**
     * Get the root component class name.
     * 
     * @return string
     */
    public static function rootComponent()
    {
        return static::componentCollection()->first(function($component) {
            return $component::root();
        });
    }

    /**
     * Get the fallback component class name.
     * 
     * @return string
     */
    public static function fallbackComponent()
    {
        return static::componentCollection()->first(function($component) {
            return $component::fallback();
        });
    }
}
