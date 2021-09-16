<?php

namespace Zareismail\Cypress;
 
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Str;
use Zareismail\Cypress\Http\Requests\CypressRequest;
use Zareismail\Cypress\Events\WidgetBooted;

abstract class Widget extends Resource implements Renderable
{   
    use AuthorizedToSee;
    use Bootable;
    use Conditionable;
    use Makeable;

    /**
     * The unique name of the widget.
     * @var string
     */
    public $name;

    /**
     * Indicates if the widget is ready to rendering.
     *
     * @var \Closure|bool
     */
    public $renderable = true;

    /**
     * Indicates if the widget should be shown on the component page.
     *
     * @var \Closure|bool
     */
    public $showOnComponent = true;

    /**
     * Indicates if the element should be shown on the fragment page.
     *
     * @var \Closure|bool
     */
    public $showOnFragment = true;

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
     * Specify that the element is ready to rendering.
     *
     * @param  \Closure|bool  $callback
     * @return $this
     */
    public function renderable($callback = true)
    {
        $this->renderable = is_callable($callback) ? function () use ($callback) {
            return call_user_func_array($callback, func_get_args());
        }
        : $callback;

        return $this;
    }

    /**
     * Specify that the element should be hidden from the component page.
     *
     * @param  \Closure|bool  $callback
     * @return $this
     */
    public function hideFromComponent($callback = true)
    {
        $this->showOnComponent = is_callable($callback) ? function () use ($callback) {
            return ! call_user_func_array($callback, func_get_args());
        }
        : ! $callback;

        return $this;
    }

    /**
     * Specify that the element should be hidden from the fragment page.
     *
     * @param  \Closure|bool  $callback
     * @return $this
     */
    public function hideFromFragment($callback = true)
    {
        $this->showOnFragment = is_callable($callback) ? function () use ($callback) {
            return ! call_user_func_array($callback, func_get_args());
        }
        : ! $callback;

        return $this;
    }

    /**
     * Specify that the element should be hidden from the component page.
     *
     * @param  \Closure|bool  $callback
     * @return $this
     */
    public function showOnComponent($callback = true)
    {
        $this->showOnComponent = $callback;

        return $this;
    }

    /**
     * Specify that the element should be hidden from the fragment page.
     *
     * @param  \Closure|bool  $callback
     * @return $this
     */
    public function showOnFragment($callback = true)
    {
        $this->showOnFragment = $callback;

        return $this;
    }

    /**
     * Specify that the widget should only be shown on the component page.
     *
     * @return $this
     */
    public function onlyOnComponent($callback = true)
    { 
        return tap($this->showOnComponent($callback), function() { 
            $this->hideFromFragment();
        }); 
    }

    /**
     * Specify that the widget should only be shown on the fragment page.
     *
     * @return $this
     */
    public function onlyOnFragment($callback = true)
    { 
        return tap($this->showOnFragment($callback), function() { 
            $this->hideFromComponent();
        }); 
    }

    /**
     * Check if renderable.
     *
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest  $request 
     * @return bool
     */
    public function isRenderable(CypressRequest $request): bool
    {
        if (! is_callable($this->renderable)) {
            return $this->renderable;
        }

        return call_user_func($this->renderable, $request);
    }

    /**
     * Check showing on component.
     *
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest  $request 
     * @return bool
     */
    public function isShownOnComponent(CypressRequest $request): bool
    {
        if (! is_callable($this->showOnComponent)) {
            return $this->showOnComponent;
        }

        return call_user_func($this->showOnComponent, $request, $request->resolveComponent());
    }

    /**
     * Check showing on fragment.
     *
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest  $request 
     * @return bool
     */
    public function isShownOnFragment(CypressRequest $request): bool
    {
        if (! is_callable($this->showOnFragment)) {
            return $this->showOnFragment;
        }

        return call_user_func($this->showOnFragment, $request, $request->resolveFragment());
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

    /**
     * Get content as a string of HTML.
     *
     * @return string
     */
    public function __toString() 
    {
        $content = $this->render();

        if ($content instanceof Renderable) {
            $content = $content->render();
        }

        if ($content instanceof Htmlable) {
            $content = $content->toHtml();
        }

        return strval($content);
    }
}
