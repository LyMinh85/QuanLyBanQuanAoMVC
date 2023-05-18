<?php
namespace Controllers;

use Core\BaseController;
use Core\Response;
use Core\Validate;
use Core\View;

class HomeController extends BaseController
{
    public function register() {
        
    }

    public function index()
    {
        View::render("home");
    }

    public function loginPage(): void {
        View::render("login");
    }

    public function login(): void {
        session_start();

        // Nếu đã đăng nhập
        if (isset($_SESSION['user'])) {
            Response::sendJson([
                'msg' => 'Already login'
            ]);
        }

        $body = Validate::getBodyData(['username', 'password']);
        $username = $body['username'];
        $password = $body['password'];

        // TODO: Find user by username and check if password is correct

        // Store user information
        $user = [
            'username' => $username,
        ];

        $_SESSION['user'] = $user;

        Response::sendJson([
            'msg' => 'login successfully'
        ]);
    }
}