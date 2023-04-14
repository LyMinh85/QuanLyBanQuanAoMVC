<?php
namespace Controllers;

use Core\BaseController;
use Core\View;

class HomeController extends BaseController
{
    public function register() {
        
    }

    public function index()
    {
        View::render("home");
    }
}