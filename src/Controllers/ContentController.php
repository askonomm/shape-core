<?php

namespace Asko\Shape\Core\Controllers;

use Asko\Shape\Core\Response;
use Asko\Shape\Core\Traits\Guardable;

class ContentController
{
    use Guardable;

    public function __construct()
    {
        $this->guard();
    }

    public function index(Response $response): Response
    {
        return $response->make("Test");
    }
}
