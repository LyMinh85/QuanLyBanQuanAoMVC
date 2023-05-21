<?php
namespace Controllers;

use Core\BaseController;
use Core\View;
use Middlewares\AuthMiddleware;

class AdministratorController extends BaseController
    {
        public function register(): void
        {
            new AuthMiddleware();
        }

        public function AdminPage(): void
        {
            $action = $this->getQuery('action');
            if ($action == null) {
                $action = "home";
            }
            \Helper::println("You are in: ", $action);
            View::render("administrator");
        }
    }
    
?>