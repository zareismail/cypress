<?php

namespace Zareismail\Cypress;
 
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Str;
use Zareismail\Cypress\Http\Requests\CypressRequest;
use Zareismail\Cypress\Events\WidgetBooted;

abstract class Widget extends Resource implements Renderable
{   
    use AuthorizedToSee;
    use Bootable;
    use Makeable;

    /**
     * The unique name of the widget.
     * @var string
     */
    public $name;

    /**
     * Create a new widget.
     *
     * @param  string  $name 
     * @return void
     */
    public function __construct(string $name)
    {
        $this->name = Str::slug($name);
    }

    /**
     * Dispatch the booting event.
     * 
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest $request 
     * @return \Zareismail\Cypress\Events\WidgetBooted                  
     */
    public function dispatchBootingEvent(CypressRequest $request)
    {
        return WidgetBooted::dispatch($request, $this);
    }

    /**
     * Prepare the resource for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), [   
            'name'    => $this->name, 
        ]);
    }   
}
