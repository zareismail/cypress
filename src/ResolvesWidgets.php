<?php

namespace Zareismail\Cypress;

use Illuminate\Http\Request;
use Zareismail\Cypress\Http\Requests\CypressRequest;
use Zareismail\Cypress\Collections\WidgetCollection;

trait ResolvesWidgets
{
    /**
     * Get the widgets that are available for the given request.
     *
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest  $request
     * @return \Illuminate\Support\Collection
     */
    public function availableWidgets(CypressRequest $request)
    {
        return $this->resolveWidgets($request)->filter->authorizedToSee($request)->values();
    }

    /**
     * Get the widgets for the given request.
     *
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest  $request
     * @return \Illuminate\Support\Collection
     */
    public function resolveWidgets(CypressRequest $request)
    {
        return new WidgetCollection($this->widgets($request));
    }

    /**
     * Get the widgets available on the entity.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function widgets(Request $request)
    {
        return [];
    }
}
