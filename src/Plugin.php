<?php

namespace Zareismail\Cypress;
 
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Renderable;
use Zareismail\Cypress\Events\PluginBooted;
use Zareismail\Cypress\Http\Requests\CypressRequest;

abstract class Plugin extends Resource implements Renderable
{   
    use AuthorizedToSee;
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

    /**
     * Get content as a string of HTML.
     *
     * @return string
     */
    public function __toString() 
    {
        $content = $this->render();

        if ($content instanceof Renderable) {
            $content = $content->render();
        }

        if ($content instanceof Htmlable) {
            $content = $content->toHtml();
        }

        return strval($content);
    }
}
