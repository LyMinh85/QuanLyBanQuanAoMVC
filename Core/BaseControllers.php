<?php

namespace Core;

/**
 * Summary of BaseController
 */
abstract class BaseController
{
    /**
     * Queries from the matched route
     * @var array
     */
    protected array $queries = [];
    /**
     * Middlewares of this controller
     * @var array
     */
    protected array $middlewares = [];

    /**
     * Class constructor
     *
     * @param array $queries  Parameters from the route
     *
     * @return void
     */
    public function __construct($queries)
    {
        $this->queries = $queries;
    }

    /**
     * Register a middleware
     */
    protected function registerMiddleware($middleware)
    {
        $this->middlewares[] = $middleware;
    }

    /**
     * Return all the registered middlewares
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
    /**
     * Magic method called when a non-existent or inaccessible method is
     * called on an object of this class. Used to execute before and after
     * filter methods on action methods. Action methods need to be named
     * with an "Action" suffix, e.g. indexAction, showAction etc.
     *
     * @param string $name  Method name
     * @param array $args Arguments passed to the method
     *
     * @return void
     */
    // public function __call($name, $args)
    // {
    //     $method = $name;

    //     if (method_exists($this, $method)) {
    //         if ($this->before() !== false) {
    //             call_user_func_array([$this, $method], $args);
    //             $this->after();
    //         }
    //     } else {
    //         throw new \Exception("Method $method not found in controller " . get_class($this));
    //     }
    // }


}
