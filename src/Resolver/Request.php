<?php

namespace phpApi\Resolver;
class Request
{
    use \phpApi\Traits\PropertyMutator;

    public function __construct()
    {
        $this->set('request', $_REQUEST);
        $this->set('server', $_SERVER);
        $this->set('headers', getallheaders());
    }

    public static function decodeExactUri($path): string
    {
        $hostDirectory = str_replace($_SERVER['DOCUMENT_ROOT'], '', $path);

        $requestWithQuery = str_replace($hostDirectory.'/', '', $_SERVER['REQUEST_URI']);

        return explode('?', $requestWithQuery)[0];
    }

    public static function intercept(): static
    {
        return new self();
    }

    public function toArray(): array
    {
        foreach ($this as $property => $value) {
            $request[$property] = $value;
        }

        return $request ?? [];
    }

    public function method() : string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function headers()
    {
        return $this->get('headers');
    }

    public function bearerToken(): ?string
    {
       $header = $this->header('Authorization');

       return $header ? trim(str_replace('Bearer', '', $header)) : null;
    }

    private function header(string $key): string
    {
        foreach ($this->get('headers') as $name => $value) {
            if ($name == $key) {
               return $value;
            }
        }

        return '';
    }

    public function input($key)
    {
        return ! $this->has($key) ? null : $this->get('data')[$key];
    }

    private function has($key): bool
    {
        return array_key_exists($key, $this->get('data'));
    }
}