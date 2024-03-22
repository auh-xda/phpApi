<?php

namespace phpApi\Resolver;

use phpApi\Traits\PropertyMutator;

class Response
{
    use PropertyMutator;

    public array $headers = [];

    public function __construct($content = [])
    {
        $this->set('content', $content);
    }

    public function error(): static
    {
        return $this->status(500);
    }

    public function success(): static
    {
        return $this->status(200);
    }

    public function redirect($to): static
    {
        $this->status(302)->set('headers', ['Location:' . $to]);

        return $this;
    }

    public function status($code): static
    {
        $this->set('statusCode', $code);

        return $this;
    }

    public function json($content = []): static
    {
        $this->set('headers', [
            'Content-Type: application/json'
        ]);

        $this->set('content', $content);

        return $this;
    }

    public function view($content): static
    {
        $this->status(200);

        $this->set('headers', [
            'Content-Type: text/html'
        ]);

        $this->set('content', $content);

        return $this;
    }

    public function render($view): static
    {
        $content = file_get_contents(srcPath('Views/' . $view . '.php'));

        return $this->view($content);
    }

    public function withCookie(Cookie $cookie): Response
    {
        $this->set('cookie', $cookie);
        return $this;
    }

    public function download()
    {

    }
}