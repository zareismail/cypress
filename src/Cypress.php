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
     * The registered widget names.
     *
     * @var array
     */
    public static $widgets = [];

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
     * Register the given widgets.
     *
     * @param  array  $widgets
     * @return static
     */
    public static function widgets(array $widgets)
    {
        static::$widgets = array_unique(
            array_merge(static::$widgets, $widgets)
        );

        return new static;
    }
}
