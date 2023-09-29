<?php

namespace Asko\Shape\Core;

use Asko\Router\Router;
use Asko\Shape\Core\Controllers\AdminController;
use Asko\Shape\Core\Controllers\LoginController;
use Asko\Shape\Core\Controllers\SetupController;
use Asko\Shape\Core\Controllers\ContentController;
use Illuminate\Database\Capsule\Manager as Database;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

class Core
{
    private ?Router $router = null;

    private function setDatabase(array $database): void
    {
        $db = new Database;
        $db->addConnection($database);
        $db->setEventDispatcher(new Dispatcher(new Container));
        $db->setAsGlobal();
        $db->bootEloquent();
    }

    private function setRoutes(): void
    {
        $this->router = new Router();
        $this->router->get("/admin", [AdminController::class, "index"]);
        $this->router->get("/admin/login", [LoginController::class, "index"]);
        $this->router->post("/admin/login", [LoginController::class, "login"]);
        $this->router->get("/admin/setup", [SetupController::class, "index"]);
        $this->router->post("/admin/setup", [SetupController::class, "setup"]);
        $this->router->get("/admin/content/{content_type}", [ContentController::class, "index"]);
        $this->router->get("/admin/content/{content_type}/add", [ContentController::class, "add"]);
        $this->router->get("/admin/content/{content_type}/edit/{content_id}", [ContentController::class, "edit"]);
    }

    private function setAppRoutes(callable $routes): void
    {
        $routes($this->router);
    }

    private function bootstrap(): void
    {
        session_start();

        if (!defined("__ROOT__")) {
            throw new \Exception("Please define __ROOT__ constant in your public/index.php file");
        }

        // Setup dotenv
        $dotenv = \Dotenv\Dotenv::createImmutable(__ROOT__);
        $dotenv->load();

        // Set-up db
        if (!file_exists(__ROOT__ . "/src/Config/database.php")) {
            throw new \Exception("Please create database.php file in your src/Config directory");
        }

        $database = include __ROOT__ . "/src/Config/database.php";
        $this->setDatabase($database);

        if (file_exists(__DIR__ . "/Config/migrations.php")) {
            $migrations = include __DIR__ . "/Config/migrations.php";

            foreach ($migrations as $migration) {
                new $migration();
            }
        }

        // Set routes
        $this->setRoutes();

        if (file_exists(__ROOT__ . "/src/Config/routes.php")) {
            $routes = include __ROOT__ . "/src/Config/routes.php";
            $this->setAppRoutes($routes);
        }
    }

    public function run(): void
    {
        $this->bootstrap();
        $this->router->dispatch();
    }
}
