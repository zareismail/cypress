<?php

namespace Zareismail\Cypress\Collections;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Stringable;
use Zareismail\Cypress\Http\Requests\CypressRequest;

class WidgetCollection extends Collection implements Renderable
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

    /**
     * Filter widgets for showing on component.
     *
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest  $request 
     * @return \Zareismail\Cypress\Collections\WidgetCollection
     */
    public function filterForComponent(CypressRequest $request)
    {
        return $this->filter->isShownOnComponent($request)->values();
    }

    /**
     * Filter widgets for showing on fragment.
     *
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest  $request 
     * @return \Zareismail\Cypress\Collections\WidgetCollection
     */
    public function filterForFragment(CypressRequest $request)
    {
        return $this->filter->isShownOnFragment($request)->values();
    }

    /**
     * Bootstrap the widgets that should be rendered for the given request.
     * 
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest $request 
     * @return void                  
     */
    public function bootstrap(CypressRequest $request, $resource)
    {
        return $this->authorized($request)->each->bootIfNotBooted($request, $resource);
    }

    /**
     * Filter widgets that should be rendered for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Zareismail\Cypress\Collections\WidgetCollection
     */
    public function authorized(Request $request)
    {
        return $this->filter->authorizedToSee($request)->values();
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        return $this->mapInto(Stringable::class)->implode('');
    }
}
