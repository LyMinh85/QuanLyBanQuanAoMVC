<?php

namespace Core;

class Route
{
    /**
     *  Http Method.
     */
    private string $method;

    /**
     *  The path for this route.
     */
    private string $path;
    
    /**
     *  The pattern for this route.
     */
    private string $pattern;
    
    /**
     * The action, controller, callable. this route points to.
     */
    private mixed $callback;
    
    /**
     *  Allows these HTTP methods.
     */
    private array $list_method = ['GET', 'POST', 'PUT', 'DELETE', 'OPTION'];
    
    public function __construct(string $method, string $path, string $pattern, mixed $callback) {
        $this->method = $method;
        $this->path = $path;
        $this->pattern = $this->cleanUrl($pattern);
        $this->callback = $callback;
    }
    
    /**
     *  reaplace all " " to "-" in url
     */
    private function cleanUrl($url): string {
        return str_replace(['%20', ' '], '-', $url);
    }

    /**
     *  get method
     */
    public function getMethod(): string {
        return $this->method;
    }

    public function getPath(): string {
        return $this->path;
    }

    /**
     *  get pattern
     */
    public function getPattern(): string {
        return $this->pattern;
    }

    /**
     *  get callback
     */
    public function getCallback(): mixed {
        return $this->callback;
    }
}