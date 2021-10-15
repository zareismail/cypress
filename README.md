###### [Installation](#installation)
###### [Components](#components)
###### [Fragments](#fragments)
###### [Layouts](#layouts)
###### [Widgets](#widgets)
###### [Plugins](#plugins)


# Installation
To install Cypress, install a new laravel project then insert the following code in root `composer.json` (follow the [composer](https://getcomposer.org/doc/05-repositories.md#vcs) tutorial):

```
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/zareismail/cypress"
        }
    ]
```

and install the Cypress: `composer require zareismail/cypress`


# Components
###### [Defining component](#defining-component)
###### [Registering Components](#registering-components)
###### [Fallback Component](#fallback-component)
###### [Customizing Uri](#customizing-uri)
###### [Attach Middleware](#attach-middleware)
###### [Authorization](#authorization)
###### [Resolvable Components](#resolving-component)


#### Defining component
By default, `Cypress` components are stored in the `app/Cypress` directory of your application. You may generate a new component using the `cypress:component` Artisan command:
```
php artisan cypress:component Blog
```

#### Registering Components
To register your component do it in the boot of a service provider; ike below:
``` 
    use Zareismail\Cypress\Cypress;
    
    
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Cypress::components([
            Blog::class,
        ]);
    }
```
Once your components are registered with Cypress, you can browse to the `/blob` path to see the result. it will be a blank page. don't worry  it will be filled via [Layout](#layouts), later. 

#### Fallback Component
The `fallback` allows you to define a component that will be executed when no other component matches the incoming request. The return value of the `fallback` method in component determines that is a fallback or not.
``` 
    /**
     * Determine if the component is a fallback component.
     *
     * @return boolean
     */
    public static function fallback(): bool
    { 
        return true;
    }
```

#### Customizing Uri
The `uriKey` method of a component enables you to customize its request path. The `uriKey` of a component using to prefix its corresponding laravel route. The `uriKey` key of a fallback component will be ignored on the route prefixing. 
```


    /**
     * Get the URI key for the resource.
     *
     * @return string
     */
    public static function uriKey()
    { 
        return Str::kebab(class_basename(get_called_class()));
    }
```

#### Attach Middleware
With the `middlewares` method of a component, you can attach some middlewares into the component corresponding routes.

```
    /**
     * Get the route middlewares.
     *
     * @return string
     */
    public static function middlewares(): array
    {  
        return [];
    }
```

#### Authorization
The  `canSee` method of the component allows you to authorize certain requests. You can use this on the [resolveable components](#resolving-component) 

```
     /**
     * Resolve the resoruce's value for the given request.
     *
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest  $request 
     * @return void
     */
    public function resolve($request): bool
    {  
        $this->canSee(function($request) {
            return boolval(rand(0, 1));
        }); 
        
        return true;
    }
```


#### Resolving Component
Each component that implements the `Zareismail\Cypress\Contracts\Resolvable` interface; allows you to do more on a component like authorization and passing data. The `resolve` method of a component allows you access to the component instance after its creation, so any component configuration should be inserted into this method. The return value of the `resolve` method determines the Cypress should respond with `404` or not which means the component is accessible or not.

```
     /**
     * Resolve the resoruce's value for the given request.
     *
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest  $request 
     * @return void
     */
    public function resolve($request): bool
    {  
        $this->canSee(function($request) {
            return boolval(rand(0, 1));
        });
        
        $this->withMeta([
            'user' => 'Say hello to blog',
        ]);
        
        return ! app()->isDownForMaintenance();
    }
```


# Fragments
###### [Defining fragments](#defining-fragments)
###### [Registering Fragments](#registering-fragments)
###### [Fallback Fragment](#fallback-fragment)
###### [Customizing Uri](#customizing-uri) 
###### [Authorization](#authorization)
###### [Resolvable Fragment](#resolving-fragment)

#### Defining Fragments
Cypress component works like a router group with default route `/`. to deep in routing you should use fragments. the following command create new fragment in the `app/Cypress/Fragments` directory.
```
    php artisan cypress:fragment Post
```
#### Registering Fragments
When a fragment defined, you need to attach it to a component. Each component generated by Cypress contains a `fragments` method. To attach a fragment to a component, you should simply add it to the array of fragments returned by this method:

```  
    use App\Cypress\Fragments\Post;
    
    /**
     * Get the component fragments.
     *
     * @return string
     */
    public function fragments(): array
    {
        return [
            Post::class, 
        ];
    }
```
After fragment registration, navigate to the `blog/posts`. you can see a new blank page. dont worry; this page also will be filled with the [Layout](#layouts) 

#### Fallback Fragment
Like [fallback components](#fallback-component) ; The `fallback`  allows you to define a fragment that will be executed when no other fragment matches the incoming request. The return value of the `fallback` method in component determines that is a fallback or not.
```  
    /**
     * Determine if the fragment is the fallback.
     *
     * @return boolean
     */
    public static function fallback(): bool
    { 
        return false;
    }
```

##### Attention
 *Each Cypress can have only one `fallback component` but have a `fallback fragment` on each component.* 
 
#### Customizing Uri
The `uriKey` method of a fragment enables you to customize its request path. But in this case; all the paths that started with the `uriKey` of the component + fragment will pass into it. 
```
    /**
     * Get the URI key for the resource.
     *
     * @return string
     */
    public static function uriKey()
    { 
        return Str::kebab(class_basename(get_called_class()));
    }
```

#### Authorization
The  `canSee` method of the fragment allows you to authorize certain requests. You can use this on the [resolveable fragments](#resolving-fragment) 

```
     /**
     * Resolve the resoruce's value for the given request.
     *
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest  $request 
     * @return void
     */
    public function resolve($request): bool
    {  
        $postId = Str::after($request->route('fragment'), 'posts/post-');

        $this->canSee(function($request) use ($postId) {
            return $postId > 10; 
        });
            
        return true;
    }
```


#### Resolving Fragment
Each fragment that implements the `Zareismail\Cypress\Contracts\Resolvable` interface; allows you to do more on a fragment like authorization and passing data. The `resolve` method of a fragment allows you access to the fragment instance after its creation, so any fragment configuration should be inserted into this method. The return value of the `resolve` method determines the Cypress should respond with `404` or not which means the fragment is accessible or not.

```
     /**
     * Resolve the resoruce's value for the given request.
     *
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest  $request 
     * @return void
     */
    public function resolve($request): bool
    {  
        $postId = Str::after($request->route('fragment'), 'posts/post-');

        $this->canSee(function($request) use ($postId) {
            return $postId > 10; 
        });
        
        $this->withMeta([ 
            'postId' => $postId
        ]);
        
        return Str::startsWith($request->route('fragment'), 'posts/post-');
    }
```

# Layouts
###### [Defining Layouts](#defining-layouts) 
###### [Registering Layouts](#registering-layouts)
###### [Layout View](#layout-view)

#### Defining Layouts
Cypress `layout` is a way to fill the page for the [components](#components) and [fragments](#fragments). following command create a new layout in `app/Cypress/Layouts` directory of your application.
```
    php artisan cypress:layout Simple
```
#### Registering Layouts
Each Cypress layout should be attached into a component. For this, you should override the `$layout` property of the component.

```  
    /**
     * The display layout class name.
     * 
     * @var string
     */
    public $layout = \App\Cypress\Layouts\Simple::class;
```
And now if you refresh the browser again, you see the blank page. To fill the layout with data you should following the [widgets](#widgets) documents.

#### Layout View

Each layout generated by Cypress has a corresponding laravel view in the `resources/views` directory of your application. The `viewName` method of a layout accepts the name of your Laravel view that you want to render for it.
```
    /**
     * Get the viewName name for the layout.
     *
     * @return string
     */
    public function viewName(): string
    {
        return 'simple';
    }
```

# Widgets
###### [Defining Widgets](#defining-widgets) 
###### [Registering Widgets](#registering-widgets)
###### [Booting](#botting)
###### [Showing / Hiding  Widgets](#showing-hiding-widgets)
###### [Widget Rendering](#widget-rendering)
###### [Widget Authorization](#widget-authorization)


#### Defining Widgets
The Cypress widgets are the way to interacts with the views. The following command create a new widget in `app/Cypress/Widgets` directory of your application.
```
    php artisan cypress:widget Post
```

#### Registering Widgets
Once you have defined a widget, you are ready to attach it to a layout. Each layout generated by Cypress contains a `widgets` method. To attach a widget to a layout, you should simply add it to the array of widgets returned by this method. Each widget requires a specific name to registering. This is  `uriKey` of the widget.

```   
    /**
     * Get the widgets available on the entity.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function widgets(Request $request)
    {
        return [
            Post::make('Widget name is required'),
        ];
    }
```
And now if you refresh the browser again, you see the content generated by the widget. 


#### Booting
The `boot` method of a widgets allows you to pass data to the widget or intracts with Cypress `layouts`, `components` and `fragments`.  This method call after component and fragment resolved. This means that you have access to the data generated by components and framengments easily.

```   
    /**
     * Bootstrap the resource for the given request.
     * 
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest $request 
     * @param  \Zareismail\Cypress\Layout $layout 
     * @return void                  
     */
    public function boot(CypressRequest $request, $layout)
    {  
        $this->withMeta([
            'psotId' => $request->resolveFragment()->metaValue('postId'),
        ]);
    }
```

#### Showing / Hiding  Widgets
Often, you will only want to display a widget in certain situations. For example, you want only display slider on the site index.
The following methods may be used to show / hide widgets based on the component requests or fragment requests:

- `hideFromComponent`
- `showOnComponent`
- `onlyOnComponent`
- `hideFromFragment`
- `showOnFragment`
- `onlyOnFragment`

You may pass a callback to this methods.
```
    /**
     * Get the widgets available on the entity.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function widgets(Request $request)
    {
        return [
            Post::make('post')->onlyOnFragment(),
        ];
    }
```

####  Widget Rendering
The `render` method of widget helps you to display content of the widget. you are free to return `view` or any `Htmlable`, `Renderable` or `string` from this method.
``` 
    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        return view('review', $this->jsonSerialize());
    }
```

#### Widget Authorization
The  `canSee` method of the widget allows you to authorize certain requests. you may chain the `canSee` method onto your widget registration:

``` 
    /**
     * Get the widgets available on the entity.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function widgets(Request $request)
    {
        return [
            Post::make('post')->canSee(function($request){
                return true;
            }),
        ];
    }
```

# Plugins
###### [Defining Plugins](#defining-plusing) 
###### [Registering Plugins](#registering-plugins) 
###### [Rendering Asset](#rendering-asset) 

#### Defining Plugins
When you creating a tempalte for a site, you need to insert `css`, `js` and another meta tag into `head` or `body`. Cypress plugins allows you to do this. The following artisan command create a new plugin in the `app/Cypress/Plugins` directory of your application.
``` 
php artisan cypress:plugin Bootstrap
```

#### Registering Plugins
Once you have defined a plugin, you are ready to attach it to a layout. Each layout generated by Cypress contains a `plugins` method. To attach a plugin to a layout, you should simply add it to the array of plugins returned by this method. 
```
    /**
     * Get the plugins available on the entity.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function plugins(Request $request)
    {
        return [
            Bootstrap::make(),
        ];
    } 
```
#### Rendering Asset
The `render` method of plugin allows you to insert some tag into the head or body of the corresponding html of the layout. For example to load the `bootstrap` assets in the template insert the following code into the created plugin.
```
    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        return '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">';
    }
```
The `asMetaData` method of plugin allows you to determine where the plugin should be render. Returning `true`  value from this method allows you render the plugin in the head of html.
``` 
    /**
     * Determine if the plugin should be loaded as html meta.
     *  
     * @return bool              
     */
    public function asMetadata(): bool
    {
        return true;
    }
```