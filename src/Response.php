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

    public function view(string $template, array $params = [], int $status = 200, array $headers = []): Response
    {
        $view = new View();
        $view->render($template, $params);

        return $this;
    }

    public function json(array $data = [], int $status = 200, array $headers = []): Response
    {
        $this->response->setContent(json_encode($data));
        $this->response->setStatusCode($status);
        $this->response->setProtocolVersion('1.0');
        $this->response->headers->set('Content-Type', 'application/json');
        $this->response->send();

        return $this;
    }

    public function html(string $content = '', int $status = 200, array $headers = []): Response
    {
        $this->response->setContent($content);
        $this->response->setStatusCode($status);
        $this->response->setProtocolVersion('1.0');
        $this->response->headers->set('Content-Type', 'text/html');
        $this->response->send();

        return $this;
    }

    public function text(string $content = '', int $status = 200, array $headers = []): Response
    {
        $this->response->setContent($content);
        $this->response->setStatusCode($status);
        $this->response->setProtocolVersion('1.0');
        $this->response->headers->set('Content-Type', 'text/plain');
        $this->response->send();

        return $this;
    }

    public function xml(string $content = '', int $status = 200, array $headers = []): Response
    {
        $this->response->setContent($content);
        $this->response->setStatusCode($status);
        $this->response->setProtocolVersion('1.0');
        $this->response->headers->set('Content-Type', 'text/xml');
        $this->response->send();

        return $this;
    }

    public function download(string $content = '', int $status = 200, array $headers = []): Response
    {
        $this->response->setContent($content);
        $this->response->setStatusCode($status);
        $this->response->setProtocolVersion('1.0');
        $this->response->headers->set('Content-Type', 'application/octet-stream');
        $this->response->send();

        return $this;
    }

    public function stream(string $content = '', int $status = 200, array $headers = []): Response
    {
        $this->response->setContent($content);
        $this->response->setStatusCode($status);
        $this->response->setProtocolVersion('1.0');
        $this->response->headers->set('Content-Type', 'application/octet-stream');
        $this->response->send();

        return $this;
    }
}
