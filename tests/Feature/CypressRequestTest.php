<?php  
 
use Zareismail\Cypress\Http\Requests\ComponentRequest;
use Zareismail\Cypress\Http\Requests\CypressRequest;
use Zareismail\Cypress\Http\Requests\FragmentRequest; 
 
it('can detect component request', function() {  
	$this->assertTrue(ComponentRequest::create('/')->isComponentRequest()); 
    $request = CypressRequest::create('/')->merge([
        CypressRequest::COMPONENT_ATTRIBUTE => 'component'
    ]);

    $this->assertFalse($request->isFragmentRequest()); 
    $this->assertTrue($request->isComponentRequest()); 
});    

it('can detect fragment request', function() {  
    $this->assertTrue(FragmentRequest::create('/')->isFragmentRequest()); 
    $request = CypressRequest::create('/')->merge([
        CypressRequest::COMPONENT_FRAGMENT => 'fragment'
    ]);

    $this->assertFalse($request->isComponentRequest()); 
    $this->assertTrue($request->isFragmentRequest()); 
});    