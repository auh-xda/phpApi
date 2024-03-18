<?php

namespace phpApi\Resolver;
use phpApi\Traits\PropertyMutator;

class Cookie
{
    use PropertyMutator;

    public function __construct($name, $value, $expiry, $domain, $path, $secure, $httpOnly)
    {
        $this->set('name', $name);
        $this->set('value', $value);
        $this->set('expiry', $expiry);
        $this->set('domain', $domain);
        $this->set('path', $path);
        $this->set('secure', $secure);
        $this->set('httponly', $httpOnly);
    }

    public function __call(string $name, array $arguments)
    {
        return $this->get(strtolower(str_replace('get', '', $name)));
    }
}