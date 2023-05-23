<?php
namespace Controllers;

use Core\BaseController;
use Core\Response;
use Core\Validate;
use Core\View;
use Models\AccountModel;
use Schemas\Account;
use function Sodium\add;

class AccountController extends BaseController{
    private AccountModel $accountModel;
    public function register(): void
    {
        $this->accountModel = new AccountModel();
    }
    public function getAccounts(): void{
        $page = (int) $this->getQuery('page');
        $resultPerPage = (int) $this->getQuery('resultPerPage');
        $name = $this->getQuery('name');

        $page = $page == 0 ? 1 : $page;
        $resultPerPage = $resultPerPage == 0 ? 20 : $resultPerPage;
        $numberOfPage = $this->accountModel->getNumberOfPage($resultPerPage);
        $accounts = [];
        if (!is_null($name)){
            $accounts = $this->accountModel->findByName($page, $resultPerPage, $name);
        }
        else{
            $accounts = $this->accountModel->getAccounts($page, $resultPerPage);
        }
        Response::sendJson([
            'pagination' => [
                'currentPage' => $page,
                'numberOfPage' => $numberOfPage
            ],
            'accounts' => $accounts,
        ]);
    }

    public function getById(int $id) {
        $account = $this->accountModel->getById($id);
        if (is_null($account)) {
            Response::sendJson("Not found");
        }
        Response::sendJson($account);
    }

    public function deleteById(int $id) {
        if ($this->accountModel->deleteById($id)) {
            Response::sendJson("Deleted account successfully");
        } else {
            Response::sendJson("Failed to delete");
        }
    }

    public function addAccount(){
        $bodyData = Validate::getBodyData(['username','password','name','gender','birthday','phone','address','email']);
        $username = $bodyData['username'];
        $password = $bodyData['password'];
        $name = $bodyData['name'];
        $gender = $bodyData['gender'];
        $input_birthday = $bodyData['birthday'];
        $birthday = \DateTime::createFromFormat('d/m/Y',$input_birthday);
        $phone = $bodyData['phone'];
        $address = $bodyData['address'];
        $email = $bodyData['email'];
        if ($this->accountModel->addAccount($username, $password,$name, $gender,$birthday, $phone, $address,$email)){
            Response::sendJson("Add success");
        } else{
            Response::sendJson("Failed to Add!!");
        }
    }
    public function updateAccount(int $id){
        $bodyData = Validate::getBodyData(['username','password','name','gender','birthday','phone','address','email']);
        $username = $bodyData['username'];
        $password = $bodyData['password'];
        $name = $bodyData['name'];
        $gender = $bodyData['gender'];
        $input_birthday = $bodyData['birthday'];
        $birthday = \DateTime::createFromFormat('d/m/Y',$input_birthday);
        $phone = $bodyData['phone'];
        $address = $bodyData['address'];
        $email = $bodyData['email'];

        $account = new Account();

        $account->id_account = $id;
        $account->username = $username;
        $account->password = $password;
        $account->name = $name;
        $account->gender = $gender;
        $account->birthday = $birthday;
        $account->phone = $phone;
        $account->address = $address;
        $account->email = $email;

        if ($this->accountModel->updateAccount($account)){
            Response::sendJson($account);
        }else{
            Response::sendJson("Fail to Update");
        }
    }

    // GET: /sign-up
    public function signUpPage(): void {
        View::render('sign-up');
    }

    // POST: /sign-up
    public function signUp(): void {
        $bodyData = Validate::getBodyData(['username','password','name','gender','birthday','phone','address','email']);
        if (isset($bodyData['error'])) {
            View::render('sign-up', [
                'missingFields' => $bodyData['missingFields']
            ]);
        }

        $username = $bodyData['username'];
        $password = $bodyData['password'];
        $name = $bodyData['name'];
        $gender = $bodyData['gender'];
        $input_birthday = $bodyData['birthday'];
        $birthday = \DateTime::createFromFormat('Y-m-d',$input_birthday);
        $phone = $bodyData['phone'];
        $address = $bodyData['address'];
        $email = $bodyData['email'];

        if ($this->accountModel->addAccount($username, $password,$name, $gender,$birthday, $phone, $address,$email)){
            Response::sendJson("Created successfully");
        } else{
            View::render('sign-up');
        }

    }

    // GET: /login
    public function loginPage(): void {
        session_start();

        if (isset($_SESSION['user'])) {
            Response::redirect('/');
        }

        View::render("login");
    }

    // POST: /login
    public function login(): void {
        session_start();

        // Nếu đã đăng nhập
        if (isset($_SESSION['user'])) {
            View::render('home');
        }

        $body = Validate::getBodyData(['username', 'password']);
        $username = $body['username'];
        $password = $body['password'];

        // TODO: Find user by username and check if password is correct
        $account = $this->accountModel->getByUsername($username);
        if ($account == null) {
            View::render('login', [
                'error' => 'Wrong username or password'
            ]);
        }

        if ($account->password != $password) {
            View::render('login', [
                'error' => 'Wrong username or password'
            ]);
        }

        // Store user information
        $user = [
            'id' => $account->id_account,
            'username' => $account->username,
            'id_group_role'=>$account->id_group_roles
        ];

        $_SESSION['user'] = $user;

        Response::redirect('/');
    }

    // GET: /logout
    public function logout(): void {
        session_start();

        // Nếu đã đăng nhập
        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
            Response::redirect('/');
        }

        Response::redirect('/');
    }
}
