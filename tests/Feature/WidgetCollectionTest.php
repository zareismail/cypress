<?php  

namespace Zareismail\Cypress\Tests\Feature; 

use Zareismail\Cypress\Collections\WidgetCollection;
use Zareismail\Cypress\Http\Requests\CypressRequest;
use Zareismail\Cypress\Http\Requests\ComponentRequest;
use Zareismail\Cypress\Http\Requests\FragmentRequest;
use Zareismail\Cypress\Tests\Fixtures\Widgets\Walker;  
use Zareismail\Cypress\Tests\Fixtures\Widgets\Welcome;   

uses(\Orchestra\Testbench\TestCase::class); 

it('excludes unauthorized widgets', function() {
	$widgets = with(CypressRequest::create('/'), function($request) {
		return WidgetCollection::make([
			Walker::make('unauthorized')->canSee(function() {
				return false;
			}),

			Welcome::make('authorized')->canSee(function() {
				return true;
			}),
		])->authorized($request);
	}); 
 
    $this->assertCount(1, $widgets);
    $this->assertEquals('authorized', $widgets->first()->name);
}); 

it('can bootstrap widgets', function() {
	$widgets = with(CypressRequest::create('/'), function($request) {
		return WidgetCollection::make([
			Walker::make('walker'),

			Welcome::make('welcome'),
		])->bootstrap($request, new \stdClass());
	}); 
 
    $this->assertCount(2, $widgets->filter->booted()); 
}); 

it('can filter widgets for component', function() {
	$widgets = with(ComponentRequest::create('/'), function($request) {
		return WidgetCollection::make([
			Walker::make('hide')->hideFromComponent(),

			Welcome::make('show'),
		])->filterForComponent($request, new \stdClass());
	});  
 
    $this->assertCount(1, $widgets);
    $this->assertEquals('show', $widgets->first()->name);
});

it('can filter widgets for fragment', function() {
	$widgets = with(FragmentRequest::create('/'), function($request) {
		return WidgetCollection::make([
			Walker::make('hide')->hideFromFragment(),

			Welcome::make('show'),
		])->filterForFragment($request, new \stdClass());
	});  
 
    $this->assertCount(1, $widgets);
    $this->assertEquals('show', $widgets->first()->name);
}); 

it('can retrive widget by name', function() {
	$widgets = WidgetCollection::make([
		Walker::make('walker'),

		Welcome::make('welcome'),
	]);  
  
    $this->assertEquals('walker', $widgets->find('walker')->name);
}); 