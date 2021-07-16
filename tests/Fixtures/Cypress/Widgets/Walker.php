<?php

namespace Zareismail\Cypress\Tests\Fixtures\Cypress\Widgets;

use Zareismail\Cypress\Widget;  
use Zareismail\Cypress\Http\Requests\CypressRequest;

class Walker extends Widget
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
        event('resolving: walker');
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    { 
        return 'I`m walking through site.';
    }
}
