<?php

namespace Asko\Shape\Core\Controllers;

use Asko\Shape\Core\Validator;
use Asko\Shape\Core\Request;
use Asko\Shape\Core\Response;
use Asko\Shape\Core\Models\User;

class SetupController
{
    public function __construct(
        private User $user,
        private Response $response,
    ) {
        // Are we set up?
        if ($this->user->find(1)) {
            $this->response->redirect("/admin/login");
        }
    }

    public function index(Response $response): Response
    {
        return $response->viewCore("setup/index", [
            'email' => '',
            'name' => '',
            'errors' => [],
        ]);
    }

    public function setup(Request $request, Response $response): Response
    {
        $validator = new Validator($request->post(), [
            "email" => "required|email",
            "name" => "required",
            "password" => "required",
            "password_again" => "required|same:password",
        ]);

        if ($validator->fails()) {
            return $response->viewCore("setup/index", [
                'email' => $request->post('email'),
                'name' => $request->post('name'),
                'errors' => $validator->errors()
            ]);
        }

        $user = new User();
        $user->email = $request->post('email');
        $user->name = $request->post('name');
        $user->password = password_hash($request->post('password'), PASSWORD_DEFAULT);
        $user->save();

        return $response->redirect("/admin/login");
    }
}
