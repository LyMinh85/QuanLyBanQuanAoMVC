<?php
namespace Controllers;

use Core\BaseController;
use Core\Response;
use Middlewares\AuthMiddleware;

class DebugController extends BaseController
{
    public function index()
    {
        Response::sendJson('Debug');
    }
}