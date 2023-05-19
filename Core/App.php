<?php

namespace Core;

use Helper;

require_once("Router.php");
require_once("Database.php");
require_once("BaseControllers.php");
require_once("View.php");
require_once("Error.php");
require_once("Route.php");
require_once("Response.php");
require_once("Request.php");
require_once("Helper.php");
require_once("Middleware.php");
require_once("Validate.php");
include("Config.php");

class App
{
    private Router $router;
    private Request $request;
    public function __construct()
    {
        /**
         * Error and Exception handling
         */
        error_reporting(E_ALL);
        set_error_handler('Core\Error::errorHandler');
        set_exception_handler('Core\Error::exceptionHandler');

        // Require all models
        $this->requireAllFile(App::getRootPath() . "/Models");

        // Require all middlewares
        $this->requireAllFile(App::getRootPath() . "/Middlewares");

        // Require all middlewares
        $this->requireAllFile(App::getRootPath() . "/Schemas");

        // Require all Enums
        $this->requireAllFile(App::getRootPath() . "/Enums");

        $this->router = new Router();
        $this->request = new Request();
    }

    // Root url without index.php
    private function redirectToRoot()
    {
        $current_url = $_SERVER['REQUEST_URI'];
        if (strpos($current_url, 'index.php') !== false) {
            Response::redirect('');
        }
    }

    public function run(): void
    {
        $this->redirectToRoot();
        $this->router->run($this->request);
    }

    public function get(string $pattern, $callback): void
    {
        $this->router->get($pattern, $callback);
    }

    public function post(string $pattern, $callback): void
    {
        $this->router->post($pattern, $callback);
    }

    public function put(string $pattern, $callback): void
    {
        $this->router->put($pattern, $callback);
    }

    public function delete(string $pattern, $callback): void
    {
        $this->router->delete($pattern, $callback);
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getRouter(): Router
    {
        return $this->router;
    }

    public static function getRootPath()
    {
        return dirname(__DIR__);
    }

    private function requireAllFile($dir)
    {
        foreach (scandir($dir) as $filename) {
            $path = $dir . '/' . $filename;
            if (is_file($path)) {
                require_once($path);
            }
        }
    }
}
