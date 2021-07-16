<?php  

namespace Zareismail\Cypress\Tests\Feature;

use Illuminate\Support\Facades\Event; 
use Illuminate\Support\Str; 
use Zareismail\Cypress\Tests\Fixtures\Blog;
use Zareismail\Cypress\Tests\Fixtures\Fragments\Fallback;
use Zareismail\Cypress\Tests\Fixtures\Fragments\Post;
use Zareismail\Cypress\Tests\Fixtures\Home; 
use Zareismail\Cypress\Tests\Fixtures\Widgets\Walker;
use Zareismail\Cypress\Tests\Fixtures\Widgets\Welcome;

uses(\Zareismail\Cypress\Tests\TestCase::class);   
 
it('can access to the component via api', function() { 
    Event::fake();

    $this
        ->getJson('/blog')
        ->assertStatus(200)
        ->assertJson([
            'uriKey' => Blog::uriKey(),
        ]);
 
    Event::assertDispatched('resolving: blog', 1);
    Event::assertNotDispatched('resolving: home');
}); 
 
it('can access to the widget through the component via api', function() { 
    Event::fake();

    $this
        ->getJson('/blog')
        ->assertStatus(200)
        ->assertDontSee('I`m walking through site.')
        ->assertJson(function($json) {
            return $json->where('layout.widgets.0.uriKey', Welcome::uriKey())
                        ->where('layout.widgets.0.name', Str::slug('Say hello'))
                        ->etc();
        });

    Event::assertDispatched('resolving: welcome', 1);  
    Event::assertNotDispatched('resolving: walker', 1);  
}); 
 
it('can access to the fragment through a component via api', function() { 
    Event::fake();
    
    $this
        ->getJson('/blog/'.Post::uriKey())
        ->assertStatus(200)
        ->assertJson([
            'uriKey' => Post::uriKey(),
        ]);

    Event::assertDispatched('resolving: blog', 1);
    Event::assertDispatched('resolving: posts', 1);
    Event::assertNotDispatched('resolving: home');
    Event::assertNotDispatched('resolving: fallback');
});  
 
it('can access to the widget through a fragment via api', function() { 
    Event::fake();

    $this
        ->getJson('/blog/'.Post::uriKey())
        ->assertStatus(200)
        ->assertDontSee('Hello World!') 
        ->assertJson(function($json) { 
            return $json->where('layout.widgets.0.uriKey', Walker::uriKey())
                        ->where('layout.widgets.0.name', Str::slug('Walk through site'))
                        ->etc();
        });

    Event::assertDispatched('resolving: walker', 1);  
    Event::assertNotDispatched('resolving: welcome');  
});
 
it('can access to the fallback fragment through a component via api', function() { 
    Event::fake();
    
    $this
        ->getJson('/blog/'. md5(time()))
        ->assertStatus(200)
        ->assertJson([
            'uriKey' => Fallback::uriKey(),
        ]);

    Event::assertDispatched('resolving: blog', 1);
    Event::assertDispatched('resolving: fallback', 1);
    Event::assertNotDispatched('resolving: home');
}); 

it('can access to the fallback component via api', function() { 
    Event::fake();

    $this
        ->getJson('/')
        ->assertStatus(200)
        ->assertJson([
            'uriKey' => Home::uriKey(),
        ]);

    Event::assertDispatched('resolving: home', 1);
    Event::assertNotDispatched('resolving: blog');
}); 

it('can access to the fragment through the fallback component via api', function() { 
    Event::fake();

    $this
        ->getJson(Post::uriKey())
        ->assertStatus(200)
        ->assertJson([
            'uriKey' => Post::uriKey(),
        ]);

    Event::assertDispatched('resolving: home', 1);
    Event::assertDispatched('resolving: posts', 1);
    Event::assertNotDispatched('resolving: blog');
});  
 
it('can access to the fallback fragment through the fallback component via api', function() { 
    Event::fake();

    $this
        ->getJson(md5(time()))
        ->assertStatus(200)
        ->assertJson([
            'uriKey' => Fallback::uriKey(),
        ]);

    Event::assertDispatched('resolving: home', 1);
    Event::assertDispatched('resolving: fallback', 1);
    Event::assertNotDispatched('resolving: blog');
    Event::assertNotDispatched('resolving: posts');
});  
 
it('can catch missing api routes', function() {
    Event::fake();

    $this
        ->getJson(md5(time()))
        ->assertStatus(200)
        ->assertJson([
            'uriKey' => Fallback::uriKey(),
        ]);

    Event::assertDispatched('resolving: home', 1);
    Event::assertDispatched('resolving: fallback', 1);
    Event::assertNotDispatched('resolving: blog');    
    Event::assertNotDispatched('resolving: posts');    
});