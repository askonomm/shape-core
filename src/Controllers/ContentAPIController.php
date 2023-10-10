<?php

use \Asko\Shape\Core\Response;

class ContentAPIController
{
    use \Asko\Shape\Core\Traits\Guardable;

    public function __construct() {
        $this->guard();
    }

    public function updateField(Response $response, string $fieldIdentifier, string $value): Response
    {
        return $response->json([
           "status" => "success"
        ]);
    }
}