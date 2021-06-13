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
     * Determine if the fragment is a fallback resource.
     *
     * @return boolean
     */
    public static function fallback(): bool
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
}
