<?php

namespace Zareismail\Cypress\Collections;
 
use Illuminate\Support\{Collection, Arr};

class ComponentCollection extends Collection
{ 
    /**
     * Find a component in the collection by key.
     *
     * @param  mixed  $key
     * @param  mixed  $default
     * @return \Zareismail\Cypress\Fragment|null
     */
    public function find(string $key, $default = null)
    { 
        return Arr::first($this->items, function ($component) use ($key) {
            return trim($component::uriKey(), '/') === trim($key, '/');
        }, $default);
    }

    /**
     * Find first fallback component in the collection.
     * 
     * @return \Zareismail\Cypress\Fragment|null
     */
    public function fallback()
    {
        return $this->first(function($component) {
            return $component::fallback();
        });
    }

}
