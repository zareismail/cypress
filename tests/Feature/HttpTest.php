<?php  

namespace Zareismail\Cypress\Tests\Feature;

use Illuminate\Support\Facades\Event;
use Zareismail\Cypress\Tests\Fixtures\Blog;  

uses(\Zareismail\Cypress\Tests\TestCase::class);   
 
it('can visit the component', function() { 
    Event::fake();

    $this->get('/blog')->assertStatus(200);

    Event::assertDispatched('resolving: blog', 1);
    Event::assertNotDispatched('resolving: home');
}); 
 
it('can visit the fragment through a component', function() { 
    Event::fake();
    
    $this->get('/blog/posts')->assertStatus(200);

    Event::assertDispatched('resolving: blog', 1);
    Event::assertDispatched('resolving: posts', 1);
    Event::assertNotDispatched('resolving: home');
}); 
 
it('can visit the fallback fragment through a component', function() { 
    Event::fake();
    
    $this->get('/blog/'. md5(time()))->assertStatus(200);

    Event::assertDispatched('resolving: blog', 1);
    Event::assertDispatched('resolving: fallback', 1);
    Event::assertNotDispatched('resolving: home');
}); 

it('can visit the fallback component', function() { 
    Event::fake();

    $this->get('/')->assertStatus(200);

    Event::assertDispatched('resolving: home', 1);
    Event::assertNotDispatched('resolving: blog');
}); 

it('can visit the fragment through the fallback component', function() { 
    Event::fake();

    $this->get('/posts')->assertStatus(200);

    Event::assertDispatched('resolving: home', 1);
    Event::assertDispatched('resolving: posts', 1);
    Event::assertNotDispatched('resolving: blog');
})->get('/blog/posts')->assertStatus(200);  
 
it('can visit the fallback fragment through the fallback component', function() { 
    Event::fake();

    $this->get(md5(time()))->assertStatus(200);

    Event::assertDispatched('resolving: home', 1);
    Event::assertDispatched('resolving: fallback', 1);
    Event::assertNotDispatched('resolving: blog');
})->get('/blog/pages')->assertStatus(200);  
 
it('can catch missing routes', function() {
    Event::fake();

    $this->get(md5(time()))->assertStatus(200);

    Event::assertDispatched('resolving: home', 1);
    Event::assertDispatched('resolving: fallback', 1);
    Event::assertNotDispatched('resolving: blog');    
});