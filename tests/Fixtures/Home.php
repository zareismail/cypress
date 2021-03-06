<?php

namespace Zareismail\Cypress\Tests\Fixtures;

use Zareismail\Cypress\Component; 
use Zareismail\Cypress\Contracts\Resolvable;
use Zareismail\Cypress\Http\Requests\CypressRequest;

class Home extends Component implements Resolvable
{    
    /**
     * The display layout class name.
     * 
     * @var string
     */ 
    public $layout = Layouts\TwentyOne::class;
    
    /**
     * Resolve the resoruce's value for the given request.
     *
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest  $request 
     * @return void
     */
    public function resolve($request): bool
    {
        event('resolving: home');
        
        return true;
    }

    /**
     * Get the component fragments.
     *
     * @return string
     */
    public function fragments(): array
    {
        return [
            Fragments\Fallback::class,
            Fragments\Post::class, 
        ];
    }
     
    /**
     * Determine if the component is a fallback component.
     *
     * @return boolean
     */
    public static function fallback(): bool
    { 
        return true;
    }
}
