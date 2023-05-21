<?php

namespace Middlewares;

use Core\Middleware;
use Core\Request;
use Core\Response;

class AuthMiddleware extends Middleware {
    // execute a middleware
    public function execute(Request $request) {
        \Helper::println("AuthMiddleware", "Hello from AuthMiddleware");
        // TODO: Check user permission
    }
}