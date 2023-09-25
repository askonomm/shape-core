<?php

namespace Asko\Shape\Core\Controllers;

use Asko\Shape\Core\Validator;
use Asko\Shape\Core\Request;
use Asko\Shape\Core\Response;

class SetupController
{
    public function index(Request $request, Response $response): Response
    {
        return $response->viewCore("setup/index", [
            'email' => ''
        ]);
    }

    public function setup(Request $request, Response $response): Response
    {
        $validator = new Validator($request->post(), [
            "email" => "required|email",
            "password" => "required",
            "password_again" => "required|same:password",
        ]);

        if ($validator->fails()) {
            return $response->viewCore("setup/index", [
                'email' => $request->post('email'),
                'errors' => $validator->errors()
            ]);
        }

        return $response->viewCore("setup/success");
    }
}
