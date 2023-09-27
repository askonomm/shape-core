<?php

namespace Asko\Shape\Core\Controllers;

use Asko\Shape\Core\Validator;
use Asko\Shape\Core\Request;
use Asko\Shape\Core\Response;
use Asko\Shape\Core\Models\User;
use Asko\Shape\Core\ContentTypes;

/** 
 * @author Asko Nõmm <asko@asko.dev>
 */
class LoginController
{
    public function __construct(
        private User $user,
        private Request $request,
        private Response $response,
    ) {
        // Are we set up?
        if (!$this->user->find(1)) {
            $this->response->redirect("/admin/setup");
        }
    }

    /**
     * The index method is responsible for rendering the login form.
     *
     * @return Response
     */
    public function index(): Response
    {
        // Set CSRF token
        $csrf_token = bin2hex(random_bytes(32));
        $this->request->session()->set("csrf_token", $csrf_token);

        return $this->response->viewCore("login/index", [
            "email" => "",
            "errors" => [],
            "csrf_token" => $csrf_token,
        ]);
    }

    /**
     * The login method is responsible for logging the user in.
     *
     * @return Response
     */
    public function login(ContentTypes $content_types): Response
    {
        $validator = new Validator($this->request->post(), [
            "email" => "required|email",
            "password" => "required",
        ]);

        // Validate CSRF
        if ($this->request->post("csrf_token") !== $this->request->session()->get("csrf_token")) {
            $validator->addError("CSRF token is invalid.");
        }

        // Validate form
        if ($validator->fails()) {
            $csrf_token = bin2hex(random_bytes(32));
            $this->request->session()->set("csrf_token", $csrf_token);

            return $this->response->viewCore("login/index", [
                "email" => $this->request->post('email'),
                "errors" => $validator->errors(),
                "csrf_token" => $csrf_token,
            ]);
        }

        // Log the user in
        $identifier = $content_types->first()->getIdentifier();

        return $this->response->redirect("/admin/content/{$identifier}");
    }
}
