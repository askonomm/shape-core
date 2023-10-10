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

        return $response->send();
    }

    public function make(string $content = '', int $status = 200, array $headers = []): Response
    {
        $this->response->setContent($content);
        $this->response->setStatusCode($status);
        $this->response->setProtocolVersion('1.0');

        return $this->response->send();
    }

    public function view(string $template, array $params = [], int $status = 200, array $headers = []): Response
    {
        $view = new View();
        $content = $view->render($template, $params);

        return $this->make($content, $status, $headers);
    }

    public function viewCore(string $template, array $params = [], int $status = 200, array $headers = []): Response
    {
        $view = new View(__DIR__ . "/Views");
        $content = $view->render($template, $params);

        return $this->make($content, $status, $headers);
    }

    public function json(array $data = [], int $status = 200, array $headers = []): Response
    {
        $this->response->setContent(json_encode($data));
        $this->response->setStatusCode($status);
        $this->response->setProtocolVersion('1.0');
        $this->response->headers->set('Content-Type', 'application/json');

        return $this->response->send();
    }

    public function html(string $content = '', int $status = 200, array $headers = []): Response
    {
        $this->response->setContent($content);
        $this->response->setStatusCode($status);
        $this->response->setProtocolVersion('1.0');
        $this->response->headers->set('Content-Type', 'text/html');

        return $this->response->send();
    }

    public function text(string $content = '', int $status = 200, array $headers = []): Response
    {
        $this->response->setContent($content);
        $this->response->setStatusCode($status);
        $this->response->setProtocolVersion('1.0');
        $this->response->headers->set('Content-Type', 'text/plain');

        return $this->response->send();
    }

    public function xml(string $content = '', int $status = 200, array $headers = []): Response
    {
        $this->response->setContent($content);
        $this->response->setStatusCode($status);
        $this->response->setProtocolVersion('1.0');
        $this->response->headers->set('Content-Type', 'text/xml');

        return $this->response->send();
    }

    public function download(string $content = '', int $status = 200, array $headers = []): Response
    {
        $this->response->setContent($content);
        $this->response->setStatusCode($status);
        $this->response->setProtocolVersion('1.0');
        $this->response->headers->set('Content-Type', 'application/octet-stream');

        return $this->response->send();
    }

    public function stream(string $content = '', int $status = 200, array $headers = []): Response
    {
        $this->response->setContent($content);
        $this->response->setStatusCode($status);
        $this->response->setProtocolVersion('1.0');
        $this->response->headers->set('Content-Type', 'application/octet-stream');

        return $this->response->send();
    }
}
