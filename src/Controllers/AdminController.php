<?php

namespace Asko\Shape\Core\Controllers;

use Asko\Shape\Core\Models\Users;
use Asko\Shape\Core\Request;
use Asko\Shape\Core\Response;
use Asko\Shape\Core\ContentTypes;
use Asko\Shape\Core\Services\AuthService;

/**
 * The Admin controller is responsible for directing the user to 
 * the correct place depending on a variety of factors such as 
 * if the site is set up, if the user is logged in, etc.
 * 
 * @author Asko Nõmm <asko@asko.dev>
 */
class AdminController
{
    public function index(
        Users        $user,
        Request      $request,
        Response     $response,
        ContentTypes $content_types,
    ): Response {
        // Are we set up?
        if (!$user->find(1)) {
            return $response->redirect("/admin/setup");
        }

        // Are we logged out?
        if (!$request->session()->get("auth_token")) {
            return $response->redirect("/admin/login");
        }

        // Are we logged in, but not authenticated?
        if (!AuthService::isAuthenticated()) {
            return $response->redirect("/admin/login");
        }

        // If we make it this far, that means all is good, 
        // and we can direct the user to the first content type.
        $identifier = $content_types->first()->getIdentifier();

        return $response->redirect("/admin/content/{$identifier}");
    }
}
