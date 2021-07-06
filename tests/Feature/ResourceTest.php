<?php  

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Renderable; 
use Illuminate\Http\JsonResponse; 
use Illuminate\Http\Response; 
use Zareismail\Cypress\Cypress;
use Zareismail\Cypress\Http\Requests\CypressRequest; 
use Zareismail\Cypress\Resource; 

uses(\Orchestra\Testbench\TestCase::class); 

it('can handle response', function() { 
    $anotherResource = new AnotherResource;   

    $response = $anotherResource->response(CypressRequest::create('/'));  
    $jsonResponse = $anotherResource->response(tap(CypressRequest::create('/'), function($request) {
        $request->headers->set('accept', 'application/json');
    }));  
    
    $this->assertTrue($response instanceof Response);  
    $this->assertTrue($jsonResponse instanceof JsonResponse);  
}); 

it('returns JSON when expected', function() { 
    $anotherResource = new AnotherResource;  
    $response = $anotherResource->response(tap(CypressRequest::create('/'), function($request) {
        $request->headers->set('accept', 'application/json');
    }));  
 
    $this->assertTrue($response instanceof JsonResponse);
    $this->assertEquals('application/json', $response->headers->get('content-type'));
    $this->assertEquals(json_encode($anotherResource->jsonSerialize()), $response->getContent());  
});  

it('returns HTML when not expects JSON', function() { 
    $anotherResource = new AnotherResource; 
    $response = $anotherResource->response(CypressRequest::create('/')); 

    $this->assertFalse($response instanceof JsonResponse);
    $this->assertNotEquals('application/json', $response->headers->get('content-type'));
    $this->assertEquals(AnotherResource::uriKey(), $response->getContent()); 
}); 

it('can detect Htmlable', function() { 
    $htmlableResource = new HtmlableResource; 
    $response = $htmlableResource->response(CypressRequest::create('/')); 

    $this->assertEquals(HtmlableResource::class, $response->getContent()); 
});

it('can detect Renderable', function() { 
    $renderableResource = new RenderableResource; 
    $response = $renderableResource->response(CypressRequest::create('/')); 

    $this->assertEquals(RenderableResource::class, $response->getContent()); 
});     


class AnotherResource extends Resource 
{ 
}

class HtmlableResource extends Resource implements Htmlable
{
    /**
     * Get content as a string of HTML.
     *
     * @return string
     */
    public function toHtml()
    {
        return static::class;
    }
}

class RenderableResource extends Resource implements Renderable
{
    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        return static::class;
    }
}