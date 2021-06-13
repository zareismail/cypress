<?php

namespace Zareismail\Cypress\Http\Controllers;

use Illuminate\Routing\Controller;
use Zareismail\Cypress\Http\Requests\ComponentRequest;
use Zareismail\Cypress\Cypress;

class ComponentController extends Controller
{
    /**
     * Display the component through a layout.
     *
     * @param  \Zareismail\Cypress\Http\Requests\FragmentRequest  $request
     * @return \Illuminate\View\View
     */
    public function handle(ComponentRequest $request)
    { 
        $component = $request->resolveComponent(); 

        return (string) $component->layout($request)->withMeta([ 
            'component' => $component->jsonSerialize(),
        ]);  
    }
}
