<?php  

use Illuminate\Support\Facades\Event;
use Zareismail\Cypress\Http\Requests\CypressRequest; 
use Zareismail\Cypress\Plugin; 

uses(\Orchestra\Testbench\TestCase::class); 

it('dispatch booting event', function() { 
    Event::fake();

    (new SimplePlugin)->bootIfNotBooted(CypressRequest::create('/'), new SimplePlugin);  

    Event::assertDispatched(\Zareismail\Cypress\Events\PluginBooted::class); 
});     


class SimplePlugin extends Plugin 
{ 
    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        return '';
    }
} 