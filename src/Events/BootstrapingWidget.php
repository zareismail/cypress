<?php

namespace Zareismail\Cypress\Events;

use Illuminate\Http\Request;
use Illuminate\Foundation\Events\Dispatchable;
use Zareismail\Cypress\Widget;

class BootstrapingWidget
{
    use Dispatchable;

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    public $request;

    /**
     * The widget instance.
     *
     * @var \Zareismail\Cypress\Widget
     */
    public $widget;

    /**
     * Create a new event instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Zareismail\Cypress\Widget  $widget
     * @return void
     */
    public function __construct(Request $request, Widget $widget)
    {
        $this->request = $request;
        $this->widget = $widget;
    }
}
