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

}
