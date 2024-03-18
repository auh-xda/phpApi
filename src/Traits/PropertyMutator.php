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

}