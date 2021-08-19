<?php  

namespace Zareismail\Cypress\Tests\Feature; 

use Zareismail\Cypress\Collections\ComponentCollection;
use Zareismail\Cypress\Http\Requests\CypressRequest;     
use Zareismail\Cypress\Tests\Fixtures\Blog; 
use Zareismail\Cypress\Tests\Fixtures\Home;

it('can find component by uriKey', function() {
	$widgets = ComponentCollection::make([
		Blog::class,
		Home::class,
	]); 
 
    $this->assertCount(2, $widgets);
    $this->assertEquals(Blog::class, $widgets->find(Blog::uriKey()));
});  

it('can find the fallback component', function() {
	$widgets = ComponentCollection::make([
		Blog::class,
		Home::class,
	]); 
 
    $this->assertCount(2, $widgets);
    $this->assertEquals(Home::class, $widgets->fallback());
});  