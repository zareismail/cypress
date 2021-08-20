<?php

namespace Zareismail\Cypress\Collections;
 
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection; 
use Illuminate\Support\Stringable;
use Zareismail\Cypress\Http\Requests\CypressRequest;

class PluginCollection extends Collection implements Htmlable
{  
    /**
     * Bootstrap the widgets that should be rendered for the given request.
     * 
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest $request 
     * @return void                  
     */
    public function bootstrap(CypressRequest $request, $resource)
    {
        return $this->each->bootIfNotBooted($request, $resource);
    }

    /**
     * Filter plugins for HTML head.
     * 
     * @return \Zareismail\Cypress\Collections\WidgetCollection
     */
    public function filterForHead()
    {
        return $this->filter->asMetadata()->values();
    }

    /**
     * Filter plugins for HTML body.
     * 
     * @return \Zareismail\Cypress\Collections\WidgetCollection
     */
    public function filterForBody()
    {
        return $this->reject->asMetadata()->values();
    }
    
    /**
     * Get content as a string of HTML.
     *
     * @return string
     */
    public function toHtml()
    { 
        return $this->mapInto(Stringable::class)->implode('');
    }
}
