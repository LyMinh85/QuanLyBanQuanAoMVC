<?php

namespace Core;

use Helper;

/**
 * Summary of Router
 */
class Router
{
    /**
     * List of Route object
     * @var array
     */
    protected array $routes = [];
    /**
     * Params of current url
     * @var array
     */
    protected array $params = [];
    /**
     * Request oject
     * @var Request
     */
    protected Request $request;

    /**
     * Querires of current url
     * @var array
     */
    protected array $queries = [];

    /**
     * Add a new route with 'GET' method
     * @param string $pattern
     * @param mixed $callback
     * @return void
     */
    public function get(string $pattern, $callback): void
    {
        $this->addRoute('GET', $pattern, $callback);
    }

    /**
     * Add a new route with 'POST' method
     * @param string $pattern
     * @param mixed $callback
     * @return void
     */
    public function post(string $pattern, $callback): void
    {
        $this->addRoute('POST', $pattern, $callback);
    }

    /**
     * Add a new route with 'PUT' method
     * @param string $pattern
     * @param mixed $callback
     * @return void
     */
    public function put(string $pattern, $callback): void
    {
        $this->addRoute('PUT', $pattern, $callback);
    }

    /**
     * Add a new route with 'PATCH' method
     * @param string $pattern
     * @param mixed $callback
     * @return void
     */
    public function patch(string $pattern, $callback): void
    {
        $this->addRoute('PATCH', $pattern, $callback);
    }

    /**
     * Add a new route with 'DELETE' method
     * @param string $pattern
     * @param mixed $callback
     * @return void
     */
    public function delete(string $pattern, $callback): void
    {
        $this->addRoute('DELETE', $pattern, $callback);
    }

    /**
     * Function convert path to regular expression
     * and create a new instance of Route then add to routes 
     * @param string $method
     * @param string $pattern
     * @param mixed $callback
     * @return void
     */
    public function addRoute(string $method, string $pattern, $callback): void
    {
        $path = $pattern;
        // Convert the route to a regular expression: escape forward slashes
        $pattern = preg_replace('/\//', '\\/', $pattern);

        // Convert variables with custom regular expressions e.g. {id:\d+}
        $pattern = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $pattern);

        // Add start and end delimiters, and case insensitive flag
        $pattern = '/^' . $pattern . '$/i';

        $this->routes[] = new Route($method, $path, $pattern, $callback);
    }

    /**
     * Get all the routes from the routing table
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * Find and get a route match the request url and method.
     * Then get params of request url.
     * @param string $url
     * @return mixed
     */
    public function getMatchRoute(string $url)
    {
        $log = [];
        foreach ($this->routes as $route) {
            if (preg_match($route->getPattern(), $url, $matches)) {
                $log[] = "Method of route: " . $route->getMethod() . "Method of request: " . $this->request->getMethod();

                if ($route->getMethod() === $this->request->getMethod()) {
                    $params = [];
                    // Get named capture group values
                    foreach ($matches as $key => $match) {
                        if (is_string($key)) {
                            $params[$key] = $match;
                        }
                    }
                    $this->params = $params;
                    return $route;
                }
            }
        }
        Helper::println("getMatchRoute", $log);
        return null;
    }

    /**
     * Get the currently matched parameters
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param Request $request
     * @return void
     */
    public function run(Request $request): void
    {
        $this->request = $request;
        $this->dispatch($request->getQueryString());
    }

    /**
     * This function receives a URL, removes any query string variables, 
     * get matches Route, and then either calls a callback function 
     * or runs a controller method based on the matched route.
     * If no route is found, it throws an exception with a 404 productStatus code.
     * @param mixed $url
     * @throws \Exception
     * @return void
     */
    public function dispatch($url): void
    {
        $url = $this->removeQueryStringVariables($url);
        $route = $this->getMatchRoute($url);
        if ($route !== null) {
            if (is_callable($route->getCallback())) {
                call_user_func($route->getCallback(), $this->params, $this->queries);
            } else {
                $this->runController($route);
            }
        } else {
            throw new \Exception('No route matched. Url: /' . $url, 404);
        }
    }

    /**
     * This function runs the controller method specified in the Route's callback.
     * It does this by parsing the callback string, finding the controller file, importing it,
     * instantiating the controller class, and calling the specified method on it.
     * If any errors occur, it throws an exception with a 404 productStatus code.
     * @param Route $route
     * @throws \Exception
     * @return mixed
     */
    public function runController(Route $route)
    {
        // Example: callback="Home@index"
        $parts = explode("@", $route->getCallback());
        // controller = "Home"
        $controller = $parts[0];
        $rootPath = dirname(__DIR__);
        // controllerFile = "Home.Controller.php"
        $controllerFile = "$rootPath/Controllers/$controller" . ".Controller.php";

        if (!is_readable($controllerFile)) {
            throw new \Exception("File $controller: $controllerFile not found.", 404);
        }
        // Import file
        require_once($controllerFile);

        // Get controller class and method
        $controller = $this->getNamespace() . $controller . "Controller";
        $method = $parts[1];

        if (class_exists($controller))
            $controller = new $controller($this->queries);
        else
            throw new \Exception("Controller class $controller not found", 404);

        if (!method_exists($controller, $method))
            throw new \Exception("Method $method is not exists in controller $controller.", 404);

        if (!method_exists($controller, "register"))
            throw new \Exception("Method register is not exists in controller $controller.", 404);

        $controller->register();

        // Run middlewares
        foreach ($controller->getMiddlewares() as $middleware) {
            $middleware->execute($this->request);
        }

        // call to method of controller
        if (is_callable([$controller, $method]))
            return call_user_func([$controller, $method], ...$this->params);
        else
            throw new \Exception("Method $method in controller $controller cannot be called directly", 404);
    }


    /**
     * Example:
     *
     *   URL                           $_SERVER['QUERY_STRING']  Route
     *   -------------------------------------------------------------------
     *   localhost                     ''                        /
     *   localhost/?                   ''                        /
     *   localhost/?page=1             page=1                    /
     *   localhost/posts?page=1        posts?page=1              posts
     *   localhost/posts/index         posts/index               posts/index
     *   localhost/posts/index?page=1  posts/index?page=1        posts/index
     */
    protected function removeQueryStringVariables(string $url): string
    {
        if ($url != '') {
            $parts = explode('?', $url, 2);
            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
                if (isset($parts[1])) {
                    $queries = explode('&', $parts[1]);
                    foreach ($queries as $query) {
                        $queryParts = explode('=', $query);
                        if (!isset($queryParts[0]) || !isset($queryParts[1])) {
                            throw new \Exception("Query '$query' does not accept.", 404);
                        }
                        $this->queries[$queryParts[0]] = $queryParts[1];
                    }
                }
            } else {
                $url = 'Debug';
            }
        }
        if ($url != '' && $url[-1] === '/') {
            $url = substr($url, 0, -1);
        } else if ($url == '') {
            $url = '/';
        }

        return $url;
    }

    /**
     * Redirect back to previous url
     */
    public function back(): void
    {
        // check if previous uri exist
        if (!headers_sent() && isset($_SERVER["HTTP_REFERER"])) {
            // redirect to previous url
            Response::redirect($_SERVER["HTTP_REFERER"], 302);
        }
    }

    /**
     * Get the namespace for the controller class.
     */
    protected function getNamespace(): string
    {
        $namespace = 'Controllers\\';
        return $namespace;
    }
}
