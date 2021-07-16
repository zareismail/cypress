<?php  

use Zareismail\Cypress\Cypress;
use Zareismail\Cypress\Http\Requests\CypressRequest;
use Zareismail\Cypress\Tests\Fixtures\Blog;
use Zareismail\Cypress\Tests\Fixtures\Error;
use Zareismail\Cypress\Tests\Fixtures\Home;

it('can get version')->assertTrue((bool) preg_match_all('/^1\.\d+\.\d+/s', Cypress::version()));

it('can get available components', function() { 
    Cypress::components($components = [
        Blog::class, 
        Home::class,
    ]);

	$this->assertEquals($components, Cypress::availableComponents(CypressRequest::create('/'))); 
});   

it('can find component for the key', function() { 
    Cypress::components([
        Blog::class, 
    ]);

	$this->assertEquals(Blog::class, Cypress::componentForKey(Blog::uriKey())); 
});    

it('can find the fallback component', function() { 
    Cypress::components([
        Blog::class, 
        Home::class,
    ]);

    $this->assertFalse(Blog::fallback()); 
    $this->assertTrue(Home::fallback());
	$this->assertEquals(Home::class, Cypress::fallbackComponent()); 
});   