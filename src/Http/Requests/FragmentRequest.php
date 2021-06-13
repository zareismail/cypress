<?php

namespace Zareismail\Cypress\Http\Requests;
 
use Zareismail\Cypress\Contracts\Resolvable;
use Zareismail\Cypress\Events\FragmentResolved;

class FragmentRequest extends ComponentRequest
{   
    /**
     * Resolve the fragment instance being requested.
     *
     * @return mixed
     */
    public function resolveFragment()
    {  
    	return once(function() {
            return tap($this->newFragment(), function($fragment) { 
                abort_if($fragment instanceof Resolvable && ! $fragment->resolve($this), 404); 
                FragmentResolved::dispatch($this, $fragment); 
                abort_unless($fragment->authorizedToSee($this), 403);
            }); 
    	}); 
    } 

    /**
     * Return a fragment instance.
     *
     * @return \Laravel\Nova\Resource
     */
    public function newFragment()
    {  
        return app()->make($this->fragment()); 
    }

    /**
     * Get the class name of the fragment being requested.
     *
     * @return mixed
     */
    public function fragment()
    {     
        return tap($this->availableFragments()->match($this->route('fragment')), function($fragment) {
            abort_if(is_null($fragment), 404);
        });
    }
}
