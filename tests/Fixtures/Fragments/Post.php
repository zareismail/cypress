<?php

namespace Zareismail\Cypress\Tests\Fixtures\Fragments;

use Illuminate\Support\Str;
use Zareismail\Cypress\Fragment; 
use Zareismail\Cypress\Contracts\Resolvable;
use Zareismail\Cypress\Http\Requests\CypressRequest; 

class Post extends Fragment implements Resolvable
{      
    /**
     * Resolve the resoruce's value for the given request.
     *
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest  $request 
     * @return void
     */
    public function resolve($request): bool
    {     
        event('resolving: posts');

        return true;
    } 
}
