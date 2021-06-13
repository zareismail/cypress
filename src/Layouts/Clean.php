<?php

namespace Zareismail\Cypress\Layouts;

use Illuminate\Http\Request;
use Zareismail\Cypress\Layout;
use Zareismail\Cypress\Widgets\Nav;

class Clean extends Layout 
{   
    /**
     * Get the viewName name for the layout.
     *
     * @return string
     */
    public function viewName(): string
    {
    	return 'cypress::layouts.clean';
    }   

    /**
     * Get the widgets available on the entity.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function widgets(Request $request)
    {
        return [ 
        ];
    } 
}
