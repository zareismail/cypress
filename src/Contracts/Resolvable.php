<?php

namespace Zareismail\Cypress\Contracts;

use Zareismail\Cypress\Http\Requests\CypressRequest;

interface Resolvable
{
    /**
     * Resolve the resoruce's value for the given request.
     *
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest  $request 
     * @return void
     */
    public function resolve($request): bool;
}
