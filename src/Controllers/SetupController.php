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
    }

    /**
     * The index method is responsible for rendering the setup form.
     *
     * @return Response
     */
    public function index(): Response
    {
        // Set CSRF token
        $csrf_token = bin2hex(random_bytes(32));
        $this->request->session()->set("csrf_token", $csrf_token);

        return $this->response->viewCore("setup/index", [
            "email" => "",
            "name" => "",
            "errors" => [],
            "csrf_token" => $csrf_token,
        ]);
    }

    /**
     * The setup method is responsible for creating the first user.
     *
     * @return Response
     */
    public function setup(): Response
    {
        $validator = new Validator($this->request->post(), [
            "email" => "required|email",
            "name" => "required",
            "password" => "required",
            "password_again" => "required|same:password",
        ]);

        // Validate CSRF
        if ($this->request->post("csrf_token") !== $this->request->session()->get("csrf_token")) {
            $validator->addError("CSRF token is invalid.");
        }

        // Validate form
        if ($validator->fails()) {
            $csrf_token = bin2hex(random_bytes(32));
            $this->request->session()->set("csrf_token", $csrf_token);

            return $this->response->viewCore("setup/index", [
                "email" => $this->request->post('email'),
                "name" => $this->request->post('name'),
                "errors" => $validator->errors(),
                "csrf_token" => $csrf_token,
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
