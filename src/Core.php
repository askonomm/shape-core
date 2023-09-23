<?php

namespace Asko\Shape\Core;

use Asko\Router\Router;
use Asko\Shape\Core\Controllers\AdminController;
use Asko\Shape\Core\Controllers\SetupController;
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
        $this->router->get("/admin/login", [AdminController::class, "login"]);
        $this->router->get("/admin/setup", [SetupController::class, "index"]);
    }

    private function setAppRoutes($router): void
    {
        $router($this->router);
    }

    private function bootstrap(): void
    {
        if (!defined("__ROOT__")) {
            define("__ROOT__", dirname(__DIR__));
        }

        if (file_exists(__ROOT__ . "/src/App/Config/routes.php")) {
            $routes = include __ROOT__ . "/src/App/Config/routes.php";
            $this->setAppRoutes($routes);
        }

        if (file_exists(__ROOT__ . "/src/App/Config/database.php")) {
            $database = include __ROOT__ . "/src/App/Config/database.php";
            $this->setDatabase($database);
        }
    }

    public function run(): void
    {
        $this->setRoutes();
        $this->bootstrap();
        $this->router->dispatch();
    }
}
