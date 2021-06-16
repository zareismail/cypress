<?php

namespace Zareismail\Cypress;

abstract class Component extends Resource
{        
    use AuthorizedToSee;
    use Displayable;
    
    /**
     * Get the host name for access to the component. Default is the application host.
     *
     * @return string
     */
    public static function host(): string
    {  
        return Cypress::host();
    }

    /**
     * Get the route middlewares.
     *
     * @return string
     */
    public static function middlewares(): array
    {  
        return [];
    }

    /**
     * Get the component fragments.
     *
     * @return string
     */
    abstract public function fragments(): array;

    /**
     * Get the route prefix for the component.
     *
     * @return string
     */
    public static function routePrefix(): string
    { 
        return static::root() ? '/' : static::uriKey();
    }
     
    /**
     * Determine if the component is a root component.
     *
     * @return boolean
     */
    public static function root(): bool
    { 
        return false;
    }
     
    /**
     * Determine if the component is a fallback component.
     *
     * @return boolean
     */
    public static function fallback(): bool
    { 
        return false;
    }

    /**
     * Get the component fragments.
     *
     * @return string
     */
    public function fragmentCollection() 
    {  
        return new Collections\FragmentCollection($this->fragments());
    }

    /**
     * Prepare the resource for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), [ 
            'fragments' => $this->fragmentCollection()->uriKeys(), 
        ]);
    }
}
