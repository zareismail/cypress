<?php  

namespace Zareismail\Cypress\Tests\Feature;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Zareismail\Cypress\Http\Requests\CypressRequest; 
use Zareismail\Cypress\Layout; 
use Zareismail\Cypress\Plugin; 
use Zareismail\Cypress\Widget; 

uses(\Orchestra\Testbench\TestCase::class); 

it('dispatch booting event', function() { 
    Event::fake();

    SimpleLayout::make()->bootIfNotBooted(CypressRequest::create('/'), SimpleLayout::make());  

    Event::assertDispatched(\Zareismail\Cypress\Events\LayoutBooted::class); 
});    

it('dispatch rendering event', function() { 
    Event::fake();

    try {
        tap(SimpleLayout::make(), function($layout) {
            $layout->bootIfNotBooted(CypressRequest::create('/'), $layout);
        })->render(); 
        
    } catch (\Exception $e) {
        
    } 

    Event::assertDispatched(\Zareismail\Cypress\Events\RenderingLayout::class); 
});     

it('can resolve plugins', function() { 
    $request = CypressRequest::create('/');
    $this->assertEquals([
        LayoutPlugin::make($request)
    ], SimpleLayout::make()->availablePlugins($request)->all());  
 
});     

it('can bootstrap plugins', function() { 
    $request = CypressRequest::create('/');

    $layout = tap(SimpleLayout::make(), function($layout) use ($request) {
        $layout->bootIfNotBooted($request, SimpleLayout::make());
    });  

    $this->assertTrue($layout->metaValue('plugins')[0]->booted());  
});     

it('can resolve widgets', function() { 
    $request = CypressRequest::create('/');
    $this->assertEquals([
        LayoutWidget::make('test')
    ], SimpleLayout::make()->availableWidgets($request)->all());  
 
});      

it('can bootstrap widgets', function() { 
    $request = CypressRequest::create('/');

    $layout = tap(SimpleLayout::make(), function($layout) use ($request) {
        $layout->bootIfNotBooted($request, SimpleLayout::make());
    }); 

    $this->assertTrue($layout->metaValue('widgets')[0]->booted());  
});     

class SimpleLayout extends Layout 
{ 
    /**
     * Get the viewName name for the layout.
     *
     * @return string
     */
    public function viewName(): string
    {
        return '';
    }

    /**
     * Get the plugins available on the entity.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function plugins(Request $request)
    {
        return [
            LayoutPlugin::make(),
        ];
    } 

    /**
     * Get the widgets available on the entity.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function widgets(Request $request)
    {
        return [
            LayoutWidget::make('test'),
        ];
    }
}      

class LayoutPlugin extends Plugin 
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

class LayoutWidget extends Widget 
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