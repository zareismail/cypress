<?php

namespace Zareismail\Cypress;

use Closure;
use Illuminate\Http\Request;

trait AuthorizedToSee
{
    /**
     * The callback used to authorize viewing the resource.
     *
     * @var \Closure|null
     */
    public $seeCallback;

    /**
     * Determine if the resource should be available for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function authorizedToSee(Request $request)
    {
        return $this->seeCallback ? call_user_func($this->seeCallback, $request) : true;
    }

    /**
     * Set the callback to be run to authorize viewing the resource.
     *
     * @param  \Closure  $callback
     * @return $this
     */
    public function canSee(Closure $callback)
    {
        $this->seeCallback = $callback;

        return $this;
    }
}
