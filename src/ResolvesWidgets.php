<?php

namespace Zareismail\Cypress;

use Illuminate\Http\Request;
use Zareismail\Cypress\Http\Requests\CypressRequest;
use Zareismail\Cypress\Collections\WidgetCollection;

trait ResolvesWidgets
{ 
    /**
     * Bootstrap component widgets.
     *
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest  $request
     * @return \Zareismail\Cypress\Collections\WidgetCollection
     */
    public function componentWidgets(CypressRequest $request)
    {
        return $this->availableWidgets($request)
                    ->filterForComponent($request)
                    ->bootstrap($request, $this)
                    ->renderable($request);
    }

    /**
     * Bootstrap fragment widgets.
     *
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest  $request
     * @return \Zareismail\Cypress\Collections\WidgetCollection
     */
    public function fragmentWidgets(CypressRequest $request)
    {
        return $this->availableWidgets($request)
                    ->filterForFragment($request)
                    ->bootstrap($request, $this)
                    ->renderable($request);
    }

    /**
     * Get the widgets that are available for the given request.
     *
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest  $request
     * @return \Zareismail\Cypress\Collections\WidgetCollection
     */
    public function availableWidgets(CypressRequest $request)
    {
        $method = $this->widgetsMethod($request);

        return WidgetCollection::make($this->{$method}($request));
    }

    /**
     * Compute the method to use to get the available widgets.
     *
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest  $request
     * @return string
     */
    protected function widgetsMethod(CypressRequest $request)
    {
        if ($request->isComponentRequest() && method_exists($this, 'widgetsForComponent')) {
            return 'widgetsForComponent';
        }

        if ($request->isFragmentRequest() && method_exists($this, 'widgetsForFragment')) {
            return 'widgetsForFragment';
        } 

        return 'widgets';
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
