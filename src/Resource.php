<?php

namespace Zareismail\Cypress;
 
use JsonSerializable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Str;
use Zareismail\Cypress\Http\Requests\CypressRequest;

abstract class Resource implements JsonSerializable, Responsable
{      
    use Metable; 

    /**
     * Get the URI key for the resource.
     *
     * @return string
     */
    public static function uriKey()
    { 
        return Str::kebab(class_basename(get_called_class()));
    }

    /**
     * Prepare the resource for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge($this->meta, [
            'uriKey' => static::uriKey(), 
        ]);
    } 

    /**
     * Transform the resource into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function response($request)
    {
        return $request->expectsJson()? $this->toJsonResponse($request) : $this->toResponse($request);
    }

    /**
     * Convert resource into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        if ($this instanceof Renderable) {
            $content = $this->render();
        } else if ($this instanceof Htmlable) {
            $content = $this->toHtml();
        } else {
            $content = static::uriKey();
        }

        return response($content);     
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toJsonResponse($request)
    {
        return response()->json($this->jsonSerialize());
    }
}
