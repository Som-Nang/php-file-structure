<?php
namespace Core;

class Container
{
    protected $bindings = [];

    public function bind($key, $resolver)
    {
        $this->bindings[$key] = $resolver;
    }

    /**
     * @throws \Exception
     */
    public function resolver($key)
    {
        if(!array_key_exists($key, $this->bindings)){
            throw new \Exception("No match binding found for {$key}");
        }
        $resolver = $this->bindings[$key];

        return call_user_func($resolver);
    }
}