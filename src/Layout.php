<?php

namespace Zareismail\Cypress;
 
use Illuminate\Contracts\Support\Htmlable;
use Zareismail\Cypress\Http\Requests\CypressRequest;
use Zareismail\Cypress\Events\{LayoutBooted, RenderingLayout};

abstract class Layout extends Resource implements Htmlable
{      
    use Bootable;  
    use Makeable;
    use ResolvesPlugins; 
    use ResolvesWidgets; 
    
    /**
     * Array of loaded plugins.
     * 
     * @var array
     */
    protected $plugins = [];

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
     * @return \Zareismail\Cypress\Events\WidgetBooted                  
     */
    public function dispatchBootingEvent(CypressRequest $request)
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
            'widgets' => $this->availableWidgets($request)->each->bootIfNotBooted($request, $this),
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
        $this->availablePlugins($request)->each(function($plugin) use ($request) {  
            $this->loadPlugin($request, $plugin);
        });

        return $this;
    }

    /**
     * Bootstrap a plugin for incoming request.
     * 
     * @param Zareismail\Cypress\Plugin $plugin 
     * @return $this
     */
    public function loadPlugin(CypressRequest $request, Plugin $plugin)
    {    
        $plugin->bootIfNotBooted($request, $this);

        $this->plugins[] = $plugin;
        
        return $this;
    } 

    /**
     * Returns list of loaded plugins.
     *  
     * @return array
     */
    public function loadedPlugins()
    {    
        return $this->plugins;
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
            'plugins' => $this->loadedPlugins(),
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
