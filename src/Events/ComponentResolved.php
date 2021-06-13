<?php

namespace Zareismail\Cypress\Events;

use Illuminate\Http\Request;
use Illuminate\Foundation\Events\Dispatchable;
use Zareismail\Cypress\Component;

class ComponentResolved
{
    use Dispatchable;

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    public $request;

    /**
     * The component instance.
     *
     * @var \Zareismail\Cypress\Component
     */
    public $component;

    /**
     * Create a new event instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Zareismail\Cypress\Component  $component
     * @return void
     */
    public function __construct(Request $request, Component $component)
    {
        $this->request = $request;
        $this->component = $component;
    }
}
