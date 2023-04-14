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

    protected abstract function register();

    /**
     * Return all the registered middlewares
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    public function getQuery(string $queryName): string|null {
        if (array_key_exists($queryName, $this->queries)) {
            return $this->queries[$queryName];
        }
        return null;
    }

}
