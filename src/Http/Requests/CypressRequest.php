<?php

namespace Zareismail\Cypress\Http\Requests;

use Illuminate\Foundation\Http\FormRequest; 

class CypressRequest extends FormRequest
{
    use InteractsWithComponents;

    /**
     * Determine if this request is an ComponentRequest request.
     *
     * @return bool
     */
    public function isComponentRequest()
    {
        return $this instanceof ComponentRequest;
    }

    /**
     * Determine if this request is an FragmentRequest request.
     *
     * @return bool
     */
    public function isFragmentRequest()
    {
        return $this instanceof FragmentRequest;
    }  
}
