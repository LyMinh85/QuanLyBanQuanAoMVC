<?php
namespace Controllers;

use Core\BaseController;
use Core\View;
    class AdministratorController extends BaseController
    {
        public function register(): void
        {
            
        
        }

        public function AdminPage(): void
        {
            View::render("administrator");
        }
    }
    
?>