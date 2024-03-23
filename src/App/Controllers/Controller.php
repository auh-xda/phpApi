<?php

namespace phpApi\App\Controllers;

use phpApi\Resolver\Request;
use phpApi\Traits\PropertyMutator;
use phpApi\Resolver\Response;

class Controller
{
    use PropertyMutator;

    public Request $request;

    public function __construct()
    {
        $this->request = request();
    }

    protected function request($key = null)
    {
        return request($key);
    }
}