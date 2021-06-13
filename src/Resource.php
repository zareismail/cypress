<?php

namespace Zareismail\Cypress;
 
use JsonSerializable;
use Illuminate\Support\Str;
use Zareismail\Cypress\Http\Requests\CypressRequest;

abstract class Resource implements JsonSerializable
{      
    use Metable; 

    /**
     * Get the URI key for the resource.
     *
     * @return string
     */
    public static function uriKey()
    { 
        return Str::kebab(class_basename(get_called_class()));
    }

    /**
     * Prepare the resource for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge($this->meta, [
            'uriKey' => static::uriKey(), 
        ]);
    }
}
