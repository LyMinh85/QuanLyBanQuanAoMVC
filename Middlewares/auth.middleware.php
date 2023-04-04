<?php

namespace Middlewares;

use Core\Middleware;
use Core\Request;
use Core\Response;

class AuthMiddleware extends Middleware {
    // execute a middleware
    public function execute(Request $request) {
        Response::logger("hello i am AuthMiddleware", "AuthMiddleware");
    }
}