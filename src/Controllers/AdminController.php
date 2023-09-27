<?php

namespace Asko\Shape\Core\Controllers;

use Asko\Shape\Core\Models\User;
use Asko\Shape\Core\Request;
use Asko\Shape\Core\Response;
use Asko\Shape\Core\ContentTypes;

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
        User $user,
        Request $request,
        Response $response,
        ContentTypes $content_types,
    ): Response {
        // Are we set up?
        if (!$user->find(1)) {
            return $response->redirect("/admin/setup");
        }

        // Are we logged out?
        // TODO: Make sure auth token matches one in DB
        if (!$request->session()->get("auth_token")) {
            return $response->redirect("/admin/login");
        }

        // If we make it this far, that means all is good, 
        // and we can direct the user to the first content type.
        return $response->redirect("/admin/content/{$content_types->first()->getSlug()}");
    }
}
