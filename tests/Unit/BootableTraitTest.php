<?php

namespace Zareismail\Cypress\Tests\Unit;

use Zareismail\Cypress\Http\Requests\CypressRequest;
use Zareismail\Cypress\Tests\Fixtures\Cypress\Blog;

it('can bootstrap an instance', function() {
    $instance = tap(new Bootable, function($instance) {
        $instance->bootIfNotBooted(CypressRequest::create('/'), new Blog);
    });

    $this->assertTrue($instance->booted()); 
    $this->assertTrue(! is_null($instance->time)); 
}); 

class Bootable
{
    use \Zareismail\Cypress\Bootable; 

    public $time = null;

    /**
     * Bootstrap the resource for the given request.
     * 
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest $request 
     * @param  \Zareismail\Cypress\Resource $resource 
     * @return void                  
     */
    public function boot(CypressRequest $request, $resource)
    {
        $this->time = time();
    }
}
