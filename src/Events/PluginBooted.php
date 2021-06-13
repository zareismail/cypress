<?php

namespace Zareismail\Cypress\Events;

use Illuminate\Http\Request;
use Illuminate\Foundation\Events\Dispatchable;
use Zareismail\Cypress\Plugin;

class PluginBooted
{
    use Dispatchable;

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    public $request;

    /**
     * The plugin instance.
     *
     * @var \Zareismail\Cypress\Plugin
     */
    public $plugin;

    /**
     * Create a new event instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Zareismail\Cypress\Plugin  $plugin
     * @return void
     */
    public function __construct(Request $request, Plugin $plugin)
    {
        $this->request = $request;
        $this->plugin = $plugin;
    }
}
