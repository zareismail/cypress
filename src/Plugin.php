<?php

namespace Zareismail\Cypress;
 
use Illuminate\Contracts\Support\Renderable;
use Zareismail\Cypress\Http\Requests\CypressRequest;
use Zareismail\Cypress\Events\PluginBooted;

abstract class Plugin extends Resource implements Renderable
{   
    use Bootable;
    use Makeable;

    /**
     * Dispatch the booting event.
     * 
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest $request 
     * @return \Zareismail\Cypress\Events\PluginBooted                  
     */
    public function dispatchBootingEvent(CypressRequest $request)
    {
        return PluginBooted::dispatch($request, $this);
    }

    /**
     * Determine if the plugin should be loaded as html meta.
     *  
     * @return bool              
     */
    public function asMetadata(): bool
    {
        return false;
    }

    /**
     * Prepare the resource for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), [    
        ]);
    }   
}
