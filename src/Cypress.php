<?php

namespace Zareismail\Cypress; 

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
        return static::componentCollection($request)->all();
    }

    /**
     * Get the component class name for a given key.
     *
     * @param  string  $key
     * @return string
     */
    public static function componentForKey(string $key)
    {
        return static::componentCollection()->first(function ($value) use ($key) {
            return trim($value::uriKey(), '/') === trim($key, '/');
        });
    }
}
