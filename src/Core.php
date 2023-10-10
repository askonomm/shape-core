<?php

namespace Asko\Shape\Core;

use Asko\Router\Router;
use Asko\Shape\Core\Controllers\AdminController;
use Asko\Shape\Core\Controllers\LoginController;
use Asko\Shape\Core\Controllers\SetupController;
use Asko\Shape\Core\Controllers\ContentController;
use Asko\Shape\Core\Controllers\ContentAPIController;
use Illuminate\Database\Capsule\Manager as Database;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

class Core
{
    /**
     * @var Router|null
     */
    private ?Router $router = null;

    /**
     * Initializes Router.
     */
    public function __construct() {
        $this->router = new Router();
    }


    /**
     * @param array $database
     * @return void
     */
    private function setDatabase(array $database): void
    {
        $db = new Database;
        $db->addConnection($database);
        $db->setEventDispatcher(new Dispatcher(new Container));
        $db->setAsGlobal();
        $db->bootEloquent();
    }

    /**
     * @return void
     */
    private function dotenv(): void
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(__ROOT__);
        $dotenv->load();
    }

    /**
     * @return void
     */
    private function setCoreRoutes(): void
    {
        if(file_exists(__DIR__ . "/Config/routes.php")) {
            $routes = include __DIR__ . "/Config/routes.php";
            $routes($this->router);
        }
    }

    /**
     * @return void
     */
    private function setAppRoutes(): void
    {
        if (file_exists(__ROOT__ . "/src/Config/routes.php")) {
            $routes = include __ROOT__ . "/src/Config/routes.php";
            $routes($this->router);
        }
    }

    /**
     * @return void
     * @throws \Exception
     */
    private function initDb(): void
    {
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
    }

    /**
     * @return void
     * @throws \Exception
     */
    private function bootstrap(): void
    {
        session_start();

        if (!defined("__ROOT__")) {
            throw new \Exception("Please define __ROOT__ constant in your public/index.php file");
        }

        $this->dotenv();
        $this->initDb();
        $this->setCoreRoutes();
        $this->setAppRoutes();
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function run(): void
    {
        $this->bootstrap();
        $this->router->dispatch();
    }
}
