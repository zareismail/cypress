<?php

namespace Zareismail\Cypress\Http\Requests;

use Illuminate\Foundation\Http\FormRequest; 
use Zareismail\Cypress\Events\ComponentResolved;
use Zareismail\Cypress\Contracts\Resolvable;
use Zareismail\Cypress\Cypress;

trait InteractsWithComponents
{   
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    /**
     * Resolve the component instance being requested.
     *
     * @return mixed
     */
    public function resolveComponent()
    {  
    	return once(function() {
            return tap($this->newComponent(), function($component) { 
                abort_if($component instanceof Resolvable && ! $component->resolve($this), 404); 
                ComponentResolved::dispatch($this, $component);
                abort_unless($component->authorizedToSee($this), 403);
            }); 
    	}); 
    }

    /**
     * Return a component instance.
     *
     * @return \Laravel\Nova\Resource
     */
    public function newComponent()
    {  
        return app()->make($this->component()); 
    }

    /**
     * Get the class name of the component being requested.
     *
     * @return mixed
     */
    public function component()
    {   
        return tap($this->matchedComponent() ?? Cypress::fallbackComponent(), function($component) {
            abort_if(is_null($component), 404);  
        });
    }

    /**
     * Get the class name of the component that matches the request.
     *
     * @return mixed
     */
    public function matchedComponent()
    {   
        $uriKey = trim($this->route()->getPrefix(), '/');

        return Cypress::componentForKey($uriKey);  

    }

    /**
     * Get the currenct component fragments.
     *
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest  $request
     * @return \Illuminate\Support\Collection
     */
    public function availableFragments()
    {     
        return $this->newComponent()->fragmentCollection(); 
    }
}
