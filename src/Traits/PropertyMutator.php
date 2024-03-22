<?php


namespace phpApi\Traits;

trait PropertyMutator
{
    public function set($property, $value)
    {
        return $this->$property = $value;
    }

    public function get($property)
    {
        return $this->$property;
    }

    public function append($property, $value)
    {
        return $this->$property[] = $value;
    }

    public function __call($method, $arguments)
    {
        $key = str_replace('get', '', $method);

        if (property_exists($this, $key)) {
            return $this->get($key);
        }

        return $this->get(strtolower($key));
    }

}