<?php

namespace Asko\Shape\Core\Controllers;

use Asko\Shape\Core\Validator;
use Asko\Shape\Core\Request;
use Asko\Shape\Core\Response;
use Asko\Shape\Core\Models\User;

/**
 * Setup controller is responsible for setting up the application 
 * by creating the first user.
 * 
 * @author Asko Nõmm <asko@asko.dev>
 */
class SetupController
{
    public function __construct(
        private User $user,
        private Request $request,
        private Response $response,
    ) {
        // Are we set up?
        if ($this->user->find(1)) {
            $this->response->redirect("/admin/login");
        }

        // Set CSRF token
        $this->request->session()->set("csrf_token", bin2hex(random_bytes(32)));
    }

    public function index(): Response
    {
        return $this->response->viewCore("setup/index", [
            "email" => "",
            "name" => "",
            "errors" => [],
            "csrf_token" => $this->request->session()->get("csrf_token"),
        ]);
    }

    public function setup(): Response
    {
        $validator = new Validator($this->request->post(), [
            "email" => "required|email",
            "name" => "required",
            "password" => "required",
            "password_again" => "required|same:password",
        ]);

        // Validate CSRF
        if ($this->request->post("csrf") !== $this->request->session()->get("csrf_token")) {
            $validator->addError("CSRF token is invalid.");
        }

        // Validate form
        if ($validator->fails()) {
            return $this->response->viewCore("setup/index", [
                "email" => $this->request->post('email'),
                "name" => $this->request->post('name'),
                "errors" => $validator->errors(),
            ]);
        }

        // Create user
        $user = new User();
        $user->email = $this->request->post('email');
        $user->name = $this->request->post('name');
        $user->password = password_hash($this->request->post('password'), PASSWORD_DEFAULT);
        $user->save();

        // Log in
        return $this->response->redirect("/admin/login");
    }
}
