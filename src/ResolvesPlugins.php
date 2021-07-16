<?php

namespace Zareismail\Cypress;

use Illuminate\Http\Request;
use Zareismail\Cypress\Http\Requests\CypressRequest;
use Zareismail\Cypress\Collections\PluginCollection;

trait ResolvesPlugins
{
    /**
     * Get the plugins that are available for the given request.
     *
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest  $request
     * @return \Illuminate\Support\Collection
     */
    public function availablePlugins(CypressRequest $request)
    {
        return $this->resolvePlugins($request)->filter->authorizedToSee($request)->values(); 
    }

    /**
     * Get the list of plugins.
     * 
     * @return \Illuminate\Support\Collection
     */
    public function resolvePlugins($request)
    {
        return new PluginCollection(array_values($this->plugins($request)));
    } 

    /**
     * Get the plugins available on the entity.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function plugins(Request $request)
    {
        return [];
    } 
}
