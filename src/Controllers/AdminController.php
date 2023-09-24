<?php

namespace Asko\Shape\Core\Controllers;

use Asko\Hird\Hird as Validator;
use Asko\Shape\Core\Models\User;
use Asko\Shape\Core\Request;
use Asko\Shape\Core\Response;

class AdminController
{
    public function __construct(private User $user, private Response $response)
    {
        // Are we set up?
        if (!$this->user->find(1)) {
            $this->response->redirect("/admin/setup");
        }
    }

    public function index(Response $response): Response
    {
        return $response->make("Admin index");
    }

    public function login(Request $request): void
    {
        if ($request->method() === "POST") {
            $validator = new Validator($request->post(), [
                "email" => "required|email",
                "password" => "required",
            ]);

            if ($validator->fails()) {
                var_dump($validator->errors());
                exit;
            }

            // $this->user->create([
            //     "username" => $request->post("username"),
            //     "password" => password_hash($request->post("password"), PASSWORD_DEFAULT),
            // ]);
        }

        echo "Admin login";
    }
}
