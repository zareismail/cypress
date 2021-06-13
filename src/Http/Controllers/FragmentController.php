<?php

namespace Zareismail\Cypress\Http\Controllers;

use Illuminate\Routing\Controller;
use Zareismail\Cypress\Http\Requests\FragmentRequest;
use Zareismail\Cypress\Cypress;

class FragmentController extends Controller
{
    /**
     * Display the fragment through a layout.
     *
     * @param  \Zareismail\Cypress\Http\Requests\FragmentRequest  $request
     * @return \Illuminate\View\View
     */
    public function handle(FragmentRequest $request)
    {  
        $component = $request->resolveComponent();  
        $fragment  = $request->resolveFragment();  

        return (string) $component->layout($request)->withMeta([
            'fragment'  => $fragment->jsonSerialize(),
            'component' => $component->jsonSerialize(),
        ]);   
    }
}
