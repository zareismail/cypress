<?php

namespace Zareismail\Cypress\Events;

use Illuminate\Http\Request;
use Illuminate\Foundation\Events\Dispatchable;
use Zareismail\Cypress\Fragment;

class FragmentResolved
{
    use Dispatchable;

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    public $request;

    /**
     * The fragment instance.
     *
     * @var \Zareismail\Cypress\Fragment
     */
    public $fragment;

    /**
     * Create a new event instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Zareismail\Cypress\Fragment  $fragment
     * @return void
     */
    public function __construct(Request $request, Fragment $fragment)
    {
        $this->request = $request;
        $this->fragment = $fragment;
    }
}
