<?php

namespace Zareismail\Cypress;
 
use Illuminate\Contracts\Support\Htmlable;
use Zareismail\Cypress\Collections\PluginCollection;
use Zareismail\Cypress\Events\BootstrapingLayout;
use Zareismail\Cypress\Events\LayoutBooted;
use Zareismail\Cypress\Events\RenderingLayout;
use Zareismail\Cypress\Http\Requests\CypressRequest;

abstract class Layout extends Resource implements Htmlable
{      
    use Bootable;  
    use Makeable;
    use ResolvesPlugins; 
    use ResolvesWidgets; 

    /**
     * Bootstrap the resource for the given request.
     * 
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest $request 
     * @return void                  
     */
    public function boot(CypressRequest $request)
    { 
        $this->bootstrapWidgets($request);

        $this->bootstrapPlugins($request);
    }

    /**
     * Dispatch the booting event.
     * 
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest $request 
     * @return \Zareismail\Cypress\Events\BootstrapingLayout                  
     */
    public function dispatchBootingEvent(CypressRequest $request)
    {
        return BootstrapingLayout::dispatch($request, $this);
    }

    /**
     * Dispatch the booted event.
     * 
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest $request 
     * @return \Zareismail\Cypress\Events\LayoutBooted                  
     */
    public function dispatchBootedEvent(CypressRequest $request)
    {
        return LayoutBooted::dispatch($request, $this);
    }

    /**
     * Bootstrap the available widgets for rendeing.
     * 
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest $request 
     * @return void                  
     */
    public function bootstrapWidgets(CypressRequest $request)
    {
        return $this->withMeta([ 
            'widgets' => $request->isComponentRequest() 
                ? $this->componentWidgets($request) 
                : $this->fragmentWidgets($request),
        ]);
    } 

    /**
     * Bootstrap the available plugins for rendeing.
     * 
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest $request 
     * @return $this                  
     */
    public function bootstrapPlugins(CypressRequest $request)
    {
        $this->appendPlugins($this->availablePlugins($request)->all());

        collect($this->metaValue('plugins'))->each->bootIfNotBooted($request, $this);

        return $this;
    }

    /**
     * Append given plugins into layout plugins.
     * 
     * @param  array  $plugins 
     * @return $this          
     */
    public function appendPlugins(array $plugins)
    {  
        return $this->withMeta([ 
            'plugins' => PluginCollection::make($this->metaValue('plugins', []))->merge($plugins),
        ]); 
    }   

    /**
     * Prepend given plugins into layout plugins.
     * 
     * @param  array  $plugins 
     * @return $this          
     */
    public function prependPlugins(array $plugins)
    {  
        return $this->withMeta([ 
            'plugins' => PluginCollection::make($plugins)->merge($this->metaValue('plugins', [])),
        ]); 
    }     

    /**
     * Get the viewName name for the layout.
     *
     * @return string
     */
    abstract public function viewName(): string;
    
    /**
     * Prepare the resource for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), [  
            'viewName' => $this->viewName(),
        ]);
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        RenderingLayout::dispatch($this->request, $this);

        return view($this->viewName(), $this->jsonSerialize());
    } 

    /**
     * Get content as a string of HTML.
     *
     * @return string
     */
    public function toHtml()
    {
        return (string) $this->render();
    }

    /**
     * Get the HTML string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toHtml();
    }
}
