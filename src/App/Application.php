<?php

namespace phpApi\App;

use phpApi\Resolver\Response;

class Application
{
    protected array $getRoutes = [];

    private string $uri = '';


    public function __construct()
    {
        if (is_string($uri = func_get_arg(0))) {
            $this->setUri($uri);
        }
    }

    public function get($url, $handler)
    {
        $this->addRoute('get', $url, $handler);
    }

    public function post($url, $handler)
    {
        $this->addRoute('post', $url, $handler);
    }

    /**
     * @throws \Exception
     */
    public function run() : Response
    {
        $uri = $this->getPropertyValue('uri');

        foreach ($this->getPropertyValue('getRoutes') as $route) {
            if ($uri == $route['url'] ) {
                return $this->callToController($route['class'], $route['method']);
            }
        }

        return response()->status(404)->json([
            'success' => false, 'message' => 'Invalid Api Endpoint'
        ]);
    }

    private function addRoute(string $method, $uri, $handler)
    {
        return $this->setPropertyValue($method.'Routes', [
            'url' => $uri,
            'class' => $handler[0],
            'method' => $handler[1]
        ]);
    }

    private function getPropertyValue($property)
    {
        return $this->$property;
    }

    private function setPropertyValue($property, $value)
    {
        if (is_array($this->$property)) {
            $this->$property[] = $value;
        } else{
            $this->$property = $value;
        }

        return $value;
    }

    private function callToController($controller, $method)
    {
        if (!class_exists($controller)) {
            throw new \Exception('Class not found '. $controller);
        }

        $returnedValue = (new $controller)->$method();

        return match (true) {
           $returnedValue instanceof Response => $returnedValue,
            default => new Response('s')
        };
    }

    public function setUri($uri): void
    {
        $this->uri = $uri;
    }

    public function resolve()
    {
        $response = $this->run();

        foreach ($response->get('headers') as $header){
            header($header);
        }

        if (in_array('Content-Type: application/json', $response->get('headers'))){
            echo json_encode(array_merge(['success' => $response->get('success'), ...$response->get('content')]));
        } else {
            echo ($response->get('content'));
        }

        http_response_code($response->get('statusCode'));
        exit();
    }
}