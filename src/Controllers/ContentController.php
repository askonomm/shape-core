<?php

namespace Asko\Shape\Core\Controllers;

use Asko\Shape\Core\Response;

class ContentController
{
    public function index(Response $response): Response
    {
        return $response->make("Test");
    }
}
