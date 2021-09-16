<?php

namespace Zareismail\Cypress;

trait Metable
{
    /**
     * The meta data for the resource.
     *
     * @var array
     */
    public $meta = [];

    /**
     * Get additional meta information to merge with the resource payload.
     * 
     * @return array
     */
    public function meta()
    { 
        return $this->meta;
    }

    /**
     * Get additional meta value for the given key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function metaValue(string $key, $default = null)
    { 
        return data_get($this->meta, $key, $default);
    }

    /**
     * Set additional meta information for the resource.
     *
     * @param  array  $meta
     * @return $this
     */
    public function withMeta(array $meta)
    {
        $this->meta = array_merge($this->meta, $meta);

        return $this;
    }

    /**
     * Determine if meta information is set.
     *
     * @param  string  $key
     * @return $this
     */
    public function hasMeta(string $key)
    { 
        return array_key_exists($key, $this->meta);
    }
}
