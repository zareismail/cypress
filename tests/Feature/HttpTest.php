<?php  

namespace Zareismail\Cypress\Tests\Feature;

use Illuminate\Support\Facades\Event;   
use Zareismail\Cypress\Tests\Fixtures\Blog; 
use Zareismail\Cypress\Tests\Fixtures\Fragments\Post; 

uses(\Zareismail\Cypress\Tests\TestCase::class);   
 
it('can visit the component', function() { 
    Event::fake();

    $this->get(Blog::uriKey())->assertStatus(200);

    Event::assertDispatched('resolving: blog', 1);
    Event::assertNotDispatched('resolving: home');
}); 
 
it('can visit the widget through the component', function() { 
    Event::fake();

    $this
        ->get(Blog::uriKey())
        ->assertStatus(200)
        ->assertDontSee('I`m walking through site.')
        ->assertSee('Hello World!');

    Event::assertDispatched('resolving: welcome', 1);  
    Event::assertNotDispatched('resolving: walker', 1);  
}); 
 
it('can visit the fragment through a component', function() { 
    Event::fake();
    
    $this->get(Blog::uriKey().'/'.Post::uriKey())->assertStatus(200);

    Event::assertDispatched('resolving: blog', 1);
    Event::assertDispatched('resolving: posts', 1);
    Event::assertNotDispatched('resolving: home');
});  
 
it('can visit the widget through a fragment', function() { 
    Event::fake();

    $this
        ->get(Blog::uriKey().'/'.Post::uriKey())
        ->assertStatus(200)
        ->assertDontSee('Hello World!')
        ->assertSee('I`m walking through site.');

    Event::assertDispatched('resolving: walker', 1);  
    Event::assertNotDispatched('resolving: welcome');  
});
 
it('can visit the fallback fragment through a component', function() { 
    Event::fake();
    
    $this->get(Blog::uriKey().'/'.md5(time()))->assertStatus(200);

    Event::assertDispatched('resolving: blog', 1);
    Event::assertDispatched('resolving: fallback', 1);
    Event::assertNotDispatched('resolving: home');
}); 

it('can visit the fallback component', function() { 
    Event::fake();

    $this->get('/')->assertStatus(200);

    Event::assertDispatched('resolving: home', 1);
    Event::assertNotDispatched('resolving: blog');
    Event::assertNotDispatched('resolving: posts', 1);
}); 

it('can visit the fragment through the fallback component', function() { 
    Event::fake();

    $this->get(Post::uriKey())->assertStatus(200);

    Event::assertDispatched('resolving: home', 1);
    Event::assertDispatched('resolving: posts', 1);
    Event::assertNotDispatched('resolving: blog');
});  
 
it('can visit the fallback fragment through the fallback component', function() { 
    Event::fake();

    $this->get(md5(time()))->assertStatus(200);

    Event::assertDispatched('resolving: home', 1);
    Event::assertDispatched('resolving: fallback', 1);
    Event::assertNotDispatched('resolving: blog');
});  
 
it('can catch missing routes', function() {
    Event::fake();

    $this->get(md5(time()))->assertStatus(200);

    Event::assertDispatched('resolving: home', 1);
    Event::assertDispatched('resolving: fallback', 1);
    Event::assertNotDispatched('resolving: blog');    
});