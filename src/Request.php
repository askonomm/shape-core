<?php

namespace Asko\Shape\Core;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class Request
{
    private SymfonyRequest $request;

    public function __construct()
    {
        $this->request = SymfonyRequest::createFromGlobals();
    }

    /**
     * Undocumented function
     *
     * @return string
     */
    public function method(): string
    {
        return $this->request->getMethod();
    }

    /**
     * Undocumented function
     *
     * @param string|null $key
     * @return mixed
     */
    public function post(string $key = null): mixed
    {
        if ($key) {
            return $this->request->request->get($key);
        }

        return $this->request->request->all();
    }

    public function get(string $key = null): mixed
    {
        if ($key) {
            return $this->request->query->get($key);
        }

        return $this->request->query->all();
    }

    public function file(string $key = null): mixed
    {
        if ($key) {
            return $this->request->files->get($key);
        }

        return $this->request->files->all();
    }

    public function cookie(string $key = null): mixed
    {
        if ($key) {
            return $this->request->cookies->get($key);
        }

        return $this->request->cookies->all();
    }

    public function header(string $key = null): mixed
    {
        if ($key) {
            return $this->request->headers->get($key);
        }

        return $this->request->headers->all();
    }

    public function server(string $key = null): mixed
    {
        if ($key) {
            return $this->request->server->get($key);
        }

        return $this->request->server->all();
    }

    public function uri(): string
    {
        return $this->request->getRequestUri();
    }

    public function path(): string
    {
        return $this->request->getPathInfo();
    }

    public function ip(): string
    {
        return $this->request->getClientIp();
    }

    public function userAgent(): string
    {
        return $this->request->headers->get('User-Agent');
    }

    public function isAjax(): bool
    {
        return $this->request->isXmlHttpRequest();
    }

    public function isSecure(): bool
    {
        return $this->request->isSecure();
    }

    public function isMethod(string $method): bool
    {
        return $this->request->isMethod($method);
    }
}
