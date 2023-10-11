<?php

use Asko\Shape\Core\Controllers\AdminController;
use Asko\Shape\Core\Controllers\ContentController;
use Asko\Shape\Core\Controllers\ContentAPIController;
use Asko\Shape\Core\Controllers\LoginController;
use Asko\Shape\Core\Controllers\SetupController;
use Asko\Shape\Core\Controllers\UploadAPIController;

return function (\Asko\Router\Router $router) {
    $router->get("/admin", [AdminController::class, "index"]);

    // Login
    $router->get("/admin/login", [LoginController::class, "index"]);
    $router->post("/admin/login", [LoginController::class, "login"]);

    // Setup
    $router->get("/admin/setup", [SetupController::class, "index"]);
    $router->post("/admin/setup", [SetupController::class, "setup"]);

    // Content
    $router->get("/admin/content/{content_type}", [ContentController::class, "index"]);
    $router->get("/admin/content/{content_type}/add", [ContentController::class, "add"]);
    $router->get("/admin/content/{content_type}/edit/{content_id}", [ContentController::class, "edit"]);
    $router->post("/admin/api/content/{content_id}/update-field", [ContentAPIController::class, "updateField"]);
    $router->post("/admin/api/upload-image", [UploadAPIController::class, "uploadImage"]);
};