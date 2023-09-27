<?php

namespace Asko\Shape\Core\Traits;

use Asko\Shape\Core\Services\AuthService;
use Asko\Shape\Core\Request;
use Asko\Shape\Core\Response;

trait Guardable
{
    public function guard(): ?Response
    {
        $auth_token = (new Request())->session()->get("auth_token");

        if (!$auth_token) {
            return (new Response())->redirect("/admin/login");
        }

        if (!AuthService::isAuthenticated($auth_token)) {
            return (new Response())->redirect("/admin/login");
        }

        return null;
    }
}
