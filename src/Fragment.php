<?php

namespace Zareismail\Cypress;

use Illuminate\Support\Str;
use Zareismail\Cypress\Http\Requests\CypressRequest;

abstract class Fragment extends Resource
{     
    use AuthorizedToSee;
     
    /**
     * Get the URI key for the resource.
     *
     * @return string
     */
    public static function uriKey()
    { 
        return Str::plural(Str::kebab(class_basename(get_called_class())));
    }
     
    /**
     * Determine if the fragment is the root.
     *
     * @return boolean
     */
    public static function root(): bool
    { 
        return false;
    }

    /**
     * Prepare the resource for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), [  
        ]);
    }  

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $component = $request->resolveComponent()->withMeta([
            'fragment' => $this->jsonSerialize(),
        ]);

        return $component->response($request);
    }     

    /**
     * Create an HTTP json response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toJsonResponse($request)
    {
        $component = $request->resolveComponent();
 
        $this->withMeta([ 
            'layout' =>  $component->layout($request)->jsonSerialize(),
        ]);

        return parent::toJsonResponse($request);
    }
}
