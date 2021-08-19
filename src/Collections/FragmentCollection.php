<?php

namespace Zareismail\Cypress\Collections;

use Illuminate\Support\{Collection, Arr, Str}; 

class FragmentCollection extends Collection
{  
    /**
     * Find a fragment in the collection by key.
     *
     * @param  mixed  $key
     * @param  mixed  $default
     * @return \Zareismail\Cypress\Fragment|null
     */
    public function find(string $key, $default = null)
    { 
        return Arr::first($this->items, function ($fragment) use ($key) {
            return $fragment::uriKey() == $key;
        }, $default);
    }

    /**
     * Find the first fragment matching a given key.
     *
     * @param  string  $key 
     * @return \Zareismail\Cypress\Fragment|null
     */
    public function match(string $key)
    { 
        return $this->first(function($fragment) use ($key) {  
            $uriKey = trim($fragment::uriKey(), '/');
            
            return Str::startsWith(trim($key, '/'), $uriKey);
        }, function() {
            return $this->fallback();
        });
    }

    /**
     * Get fallback fragments.
     *
     * @return \Zareismail\Cypress\Fragment|null
     */
    public function fallback()
    { 
        return $this->first(function($fragment) {  
            return $fragment::fallback();
        });
    } 

    /**
     * Get the array of uri keys.
     *
     * @return array
     */
    public function uriKeys()
    {
        return array_map(function ($fragment) {
            return $fragment::uriKey();
        }, $this->items);
    } 
}