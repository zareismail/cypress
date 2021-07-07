<?php  

namespace Zareismail\Cypress\Tests\Feature;

use Illuminate\Support\Facades\Event;
use Zareismail\Cypress\Http\Requests\CypressRequest; 
use Zareismail\Cypress\Layout; 
use Zareismail\Cypress\Plugin; 

uses(\Orchestra\Testbench\TestCase::class); 

it('dispatch booting event', function() { 
    Event::fake();

    SimplePlugin::make()->bootIfNotBooted(CypressRequest::create('/'), PluginLayout::make());  

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

class PluginLayout extends Layout 
{ 
    /**
     * Get the viewName name for the layout.
     *
     * @return string
     */
    public function viewName(): string
    {

    }
} 