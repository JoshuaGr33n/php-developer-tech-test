<?php

namespace App;

class Container
{
    private $bindings = [];

    public function bind($key, callable $resolver)
    {
        $this->bindings[$key] = $resolver;
    }

    public function resolve($key)
    {
        if (!isset($this->bindings[$key])) {
            throw new \Exception("No binding found for {$key}");
        }

        return $this->bindings[$key]($this);
    }
}
