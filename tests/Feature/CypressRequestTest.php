<?php  
 
use Zareismail\Cypress\Http\Requests\ComponentRequest;
use Zareismail\Cypress\Http\Requests\CypressRequest;
use Zareismail\Cypress\Http\Requests\FragmentRequest; 
 
it('can detect component request', function() {  
	$this->assertTrue(ComponentRequest::create('/')->isComponentRequest()); 

    $this->assertTrue(CypressRequest::create('/')->merge([
        CypressRequest::COMPONENT_ATTRIBUTE => 'component'
    ])->isComponentRequest()); 
});    

it('can detect fragment request', function() {  
    $this->assertTrue(FragmentRequest::create('/')->isFragmentRequest()); 
    
    $this->assertTrue(CypressRequest::create('/')->merge([
        CypressRequest::COMPONENT_FRAGMENT => 'fragment'
    ])->isFragmentRequest()); 
});    