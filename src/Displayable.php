<?php

namespace Zareismail\Cypress;
  
use Zareismail\Cypress\Http\Requests\CypressRequest;

trait Displayable
{      
    /**
     * The display layout class name.
     * 
     * @var string
     */
    public $layout = Layouts\Clean::class;

    /**
     * Set the layout that should be used by the resource.
     *
     * @param  string  $layout
     * @return $this
     */ 
    public function useLayout(string $layout)
    {
        $this->layout = $layout;

        return $this;
    }

    /**
     * Get the layout instance.
     * 
     * @return string                  
     */
    public function resolveLayout()
    { 
        return forward_static_call([$this->layout, 'make']); 
    }  

    /**
     * Prepare layout to display.
     * 
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest $request 
     * @return \Zareismail\Cypress\Layout                  
     */
    public function layout(CypressRequest $request)
    { 
        return tap($this->resolveLayout(), function($layout) use ($request) { 
            $layout->bootIfNotBooted($request, $this);
        });
    }   
}
