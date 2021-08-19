<?php  

namespace Zareismail\Cypress\Tests\Feature; 

use Zareismail\Cypress\Collections\ComponentCollection;
use Zareismail\Cypress\Http\Requests\CypressRequest;     
use Zareismail\Cypress\Tests\Fixtures\Blog; 
use Zareismail\Cypress\Tests\Fixtures\Home;

it('can find component by uriKey', function() {
	$components = ComponentCollection::make([
		Blog::class,
		Home::class,
	]); 
 
    $this->assertCount(2, $components);
    $this->assertEquals(Blog::class, $components->find(Blog::uriKey()));
});  

it('can find the fallback component', function() {
	$components = ComponentCollection::make([
		Blog::class,
		Home::class,
	]); 
 
    $this->assertCount(2, $components);
    $this->assertEquals(Home::class, $components->fallback());
});  