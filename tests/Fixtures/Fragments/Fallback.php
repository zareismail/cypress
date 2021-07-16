<?php

namespace Zareismail\Cypress\Tests\Fixtures\Fragments;

use Illuminate\Support\Str;
use Zareismail\Cypress\Fragment; 
use Zareismail\Cypress\Contracts\Resolvable;
use Zareismail\Cypress\Http\Requests\CypressRequest; 

class Fallback extends Fragment implements Resolvable
{      
    /**
     * Resolve the resoruce's value for the given request.
     *
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest  $request 
     * @return void
     */
    public function resolve($request): bool
    {     
        event('resolving: fallback');

        return true;
    } 
     
    /**
     * Determine if the fragment is the fallback.
     *
     * @return boolean
     */
    public static function fallback(): bool
    { 
        return true;
    }
}
