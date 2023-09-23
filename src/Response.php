<?php

namespace Asko\Shape\Core;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Response
{
    private SymfonyResponse $response;

    public function __construct()
    {
        $this->response = new SymfonyResponse();
    }

    public function redirect(string $to, int $status = 302, array $headers = []): Response
    {
        $response = new RedirectResponse($to, $status, $headers);
        $response->send();

        return $this;
    }

    public function make(string $content = '', int $status = 200, array $headers = []): Response
    {
        $this->response->setContent($content);
        $this->response->setStatusCode($status);
        $this->response->setProtocolVersion('1.0');
        $this->response->send();

        return $this;
    }
}
