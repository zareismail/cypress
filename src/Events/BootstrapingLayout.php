<?php

namespace Zareismail\Cypress\Events;

use Illuminate\Http\Request;
use Illuminate\Foundation\Events\Dispatchable;
use Zareismail\Cypress\Layout;

class BootstrapingLayout
{
    use Dispatchable;

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    public $request;

    /**
     * The layout instance.
     *
     * @var \Zareismail\Cypress\Layout
     */
    public $layout;

    /**
     * Create a new event instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Zareismail\Cypress\Layout  $layout
     * @return void
     */
    public function __construct(Request $request, Layout $layout)
    {
        $this->request = $request;
        $this->layout = $layout;
    }
}
