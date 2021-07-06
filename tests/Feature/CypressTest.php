<?php  

use Zareismail\Cypress\Cypress;
use Zareismail\Cypress\Http\Requests\CypressRequest;
use Zareismail\Cypress\Tests\Fixtures\Cypress\Blog;
use Zareismail\Cypress\Tests\Fixtures\Cypress\Error;
use Zareismail\Cypress\Tests\Fixtures\Cypress\Home;

it('can get version')->assertTrue((bool) preg_match_all('/^1\.\d+\.\d+/s', Cypress::version()));

it('can get available components', function() { 
    Cypress::components($components = [
        Blog::class,
        Error::class,
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

it('can find the root component', function() { 
    Cypress::components([
        Blog::class,
        Error::class,
        Home::class,
    ]);

    $this->assertFalse(Blog::root());
    $this->assertFalse(Error::root());
    $this->assertTrue(Home::root());
	$this->assertEquals(Home::class, Cypress::rootComponent()); 
});  

it('can find the fallback component', function() { 
    Cypress::components([
        Error::class, 
    ]);

    $this->assertTrue(Error::fallback());
	$this->assertEquals(Error::class, Cypress::fallbackComponent()); 
});   