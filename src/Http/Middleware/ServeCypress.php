<?php

namespace Zareismail\Cypress\Http\Middleware;

use Illuminate\Support\Str;
use Zareismail\Cypress\Events\CypressServiceProviderRegistered;
use Zareismail\Cypress\Cypress;

class ServeCypress
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        if ($this->isCypressRequest($request)) {
            CypressServiceProviderRegistered::dispatch();
        }

        return $next($request);
    }

    /**
     * Determine if the given request is intended for Cypress.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function isCypressRequest($request)
    {
        return collect(config('cypress.excepts', []))->filter(function($path) {
            return $request->is($path) || $request->is(trim($path.'/*', '/'));
        })->isEmpty(); 
    }
}
