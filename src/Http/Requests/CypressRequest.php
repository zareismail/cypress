<?php

namespace Zareismail\Cypress\Http\Requests;

use Illuminate\Foundation\Http\FormRequest; 

class CypressRequest extends FormRequest
{
    use InteractsWithComponents;

    /**
     * Get name input of the component.
     *
     * @var string
     */
    const COMPONENT_ATTRIBUTE = 'cypress_component';

    /**
     * Get name input of the fragment.
     * 
     * @var string
     */
    const COMPONENT_FRAGMENT = 'cypress_fragment';

    /**
     * Determine if this request is an ComponentRequest request.
     *
     * @return bool
     */
    public function isComponentRequest()
    {
        return $this instanceof ComponentRequest || $this->filled(static::COMPONENT_ATTRIBUTE);
    }

    /**
     * Determine if this request is an FragmentRequest request.
     *
     * @return bool
     */
    public function isFragmentRequest()
    {
        return $this instanceof FragmentRequest || $this->filled(static::COMPONENT_FRAGMENT);
    }  
}
