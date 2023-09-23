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
}
