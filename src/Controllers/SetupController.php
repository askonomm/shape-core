<?php

namespace Asko\Shape\Core\Controllers;

use Asko\Shape\Core\Request;
use Asko\Shape\Core\Response;

class SetupController
{
    public function index(Request $request, Response $response): Response
    {
        return $response->viewCore("setup/index");
    }
}
