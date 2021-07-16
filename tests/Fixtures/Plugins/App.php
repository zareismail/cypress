<?php

namespace Zareismail\Cypress\Tests\Fixtures\Plugins;

use Zareismail\Cypress\Plugin;  
use Zareismail\Cypress\Http\Requests\CypressRequest;

class App extends Plugin
{       
    /**
     * Bootstrap the resource for the given request.
     * 
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest $request 
     * @param  \Zareismail\Cypress\Layout $layout 
     * @return void                  
     */
    public function boot(CypressRequest $request, $layout)
    {  
        event('resolving: app');
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    { 
        return '<script>console.log("app")</script>';
    }
}
