<?php

namespace Zareismail\Cypress\Tests\Unit;

it('can initiate an instance', function() {
    $instance = Makeable::make('first', 'second');

    $this->assertEquals('first', $instance->first);
    $this->assertEquals('second', $instance->second);
}); 

class Makeable
{
    use \Zareismail\Cypress\Makeable;

    public $first;
    public $second;

    public function __construct($first, $second)
    {
        $this->first = $first;
        $this->second = $second;
    }
}
