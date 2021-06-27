<?php

namespace Zareismail\Cypress\Http\Controllers;

use Illuminate\Routing\Controller;
use Zareismail\Cypress\Http\Requests\WidgetRequest;  

class WidgetController extends Controller
{
    /**
     * Display a widget for the given request.
     *
     * @param  \Zareismail\Cypress\Http\Requests\WidgetRequest  $request
     * @return \Illuminate\View\View
     */
    public function handle(WidgetRequest $request)
    { 
        return $request->widget()->response($request);   
    } 
}
