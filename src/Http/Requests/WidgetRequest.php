<?php

namespace Zareismail\Cypress\Http\Requests;

class WidgetRequest extends FragmentRequest
{      
    /**
     * Get bootstrapped instance of the widget being requested.
     *
     * @param string|null $uriKey
     * @return mixed
     */
    public function widget(string $widgetName = null)
    {  
        return once(function() use ($widgetName) { 
            return tap($this->findWidgetOrFail($widgetName), function($widget) {
                $widget->bootIfNotBooted($this, $this->resolveComponent()->resolveLayout());
            });  
        }); 
    } 

    /**
     * Get the instance of the widget being requested.
     *
     * @param string|null $widgetName
     * @return mixed
     */
    public function findWidgetOrFail(string $widgetName = null)
    {
        $widgets = $this->resolveComponent()->resolveLayout()->availableWidgets($this);

        return tap($widgets->find($this->route('widget', $widgetName)), function($widget) {
            abort_if(is_null($widget), 404);
        });
    }

    /**
     * Get the class name of the fragment being requested.
     *
     * @param string|null $uriKey
     * @return mixed
     */
    public function fragment($uriKey = null)
    {      
        return parent::fragment($uriKey ?? $this->fragment); 
    }
}
