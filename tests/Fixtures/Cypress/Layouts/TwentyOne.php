<?php

namespace Zareismail\Cypress\Tests\Fixtures\Cypress\Layouts;

use Illuminate\Http\Request;
use Zareismail\Cypress\Layout;  
use Zareismail\Cypress\Tests\Fixtures\Cypress\Widgets\Walker;
use Zareismail\Cypress\Tests\Fixtures\Cypress\Widgets\Welcome;

class TwentyOne extends Layout
{        
    /**
     * Get the viewName name for the layout.
     *
     * @return string
     */
    public function viewName(): string
    {
        return 'cypress-test::twenty-one';
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
            Walker::make('Walk through site')->canSee(function($request) {
                return $request->isFragmentRequest();
            }), 

            Welcome::make('Say hello')->canSee(function($request) {
                return $request->isComponentRequest();
            }),
        ];
    }

    /**
     * Get the plugins available on the entity.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function plugins(Request $request)
    {
        return [
        ];
    } 
}
