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

    public function error($status = 500): static
    {
        return $this->status($status);
    }

    public function success(): static
    {
        $this->set('success', true);

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
        return $this->view(file_get_contents(srcPath('Views/' . $view . '.php')));
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