<?php

namespace Zareismail\Cypress\Collections;
 
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class WidgetCollection extends Collection
{ 
    /**
     * Find a widget in the collection by key.
     *
     * @param  mixed  $key
     * @param  mixed  $default
     * @return \Zareismail\Cypress\Fragment|null
     */
    public function find(string $key, $default = null)
    { 
        return Arr::first($this->items, function ($widget) use ($key) {
            return $widget->name == $key;
        }, $default);
    }
}
