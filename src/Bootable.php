<?php

namespace Zareismail\Cypress;
  
use Zareismail\Cypress\Http\Requests\CypressRequest;

trait Bootable
{      
    /**
     * The booting status.
     *
     * @var array
     */
    protected $booted = false;  

    /**
     * The request instance.
     *
     * @var \Zareismail\Cypress\Http\Requests\CypressRequest
     */
    protected $request; 

    /**
     * Check if the resource needs to be booted and if so, do it.
     * 
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest $request 
     * @param  \Zareismail\Cypress\Resource $resource 
     * @return void                  
     */
    public function bootIfNotBooted(CypressRequest $request, $resource)
    {   
        if (! $this->booted()) {

            $this->setRequest($request);

            $this->boot($request, $resource); 

            $this->dispatchBootingEvent($request);
            
            $this->booted = true; 
        }
    } 

    /**
     * Dispatch the booting event.
     * 
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest $request 
     * @return \Zareismail\Cypress\Events\WidgetBooted                  
     */
    public function dispatchBootingEvent(CypressRequest $request)
    {

    } 

    /**
     * Determine if the resource booted.
     * 
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest $request 
     * @return void                  
     */
    public function booted()
    {   
        return $this->booted;
    }

    /**
     * Set the request instance.
     * 
     * @param \Zareismail\Cypress\Http\Requests\CypressRequest $request
     */
    public function setRequest(CypressRequest $request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Get the request instance.
     * 
     * @return \Zareismail\Cypress\Http\Requests\CypressRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Bootstrap the resource for the given request.
     * 
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest $request 
     * @param  \Zareismail\Cypress\Resource $resource 
     * @return void                  
     */
    public function boot(CypressRequest $request, $resource)
    {

    }
}
