<?php  

use Illuminate\Support\Facades\Event;
use Zareismail\Cypress\Http\Requests\CypressRequest; 
use Zareismail\Cypress\Layout; 
use Zareismail\Cypress\Widget; 

uses(\Orchestra\Testbench\TestCase::class); 

it('dispatch booting event', function() { 
    Event::fake();

    SimpleWidget::make('simple')->bootIfNotBooted(CypressRequest::create('/'), SimpleLayout::make()); 

    Event::assertDispatched(\Zareismail\Cypress\Events\WidgetBooted::class); 
});  

class SimpleWidget extends Widget 
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

class SimpleLayout extends Layout 
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