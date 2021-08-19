<?php  

namespace Zareismail\Cypress\Tests\Feature; 

use Zareismail\Cypress\Collections\FragmentCollection;
use Zareismail\Cypress\Http\Requests\CypressRequest;     
use Zareismail\Cypress\Tests\Fixtures\Fragments\Fallback; 
use Zareismail\Cypress\Tests\Fixtures\Fragments\Post;

it('can find fragment by uriKey', function() {
	$fragments = FragmentCollection::make([
		Post::class,
		Fallback::class,
	]); 
 
    $this->assertCount(2, $fragments);
    $this->assertEquals(Post::class, $fragments->find(Post::uriKey()));
});  

it('can find fragment for request path that started by fragment uriKey', function() {
	$fragments = FragmentCollection::make([
		Post::class,
		Fallback::class,
	]); 
 
    $this->assertCount(2, $fragments);
    $this->assertEquals(Post::class, $fragments->match(Post::uriKey()));
    $this->assertEquals(Post::class, $fragments->match(Post::uriKey().'/'.md5(time())));
    $this->assertEquals(Fallback::class, $fragments->match(Post::uriKey().md5(time())));
});  

it('can find fallback fragment', function() {
	$fragments = FragmentCollection::make([
		Post::class,
		Fallback::class,
	]); 
 
    $this->assertCount(2, $fragments);
    $this->assertEquals(Fallback::class, $fragments->fallback()); 
});  

it('can return the uri keys', function() {
	$fragments = FragmentCollection::make([
		Post::class,
		Fallback::class,
	]); 
  
    $this->assertEquals([
    	Post::uriKey(),
    	Fallback::uriKey(),
    ], $fragments->uriKeys()); 
});  