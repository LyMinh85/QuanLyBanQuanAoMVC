<?php

namespace Controllers;


use Core\BaseController;
use Core\Response;
use Core\Validate;
use Models\AccountModel;

class AccountController extends BaseController{
    private AccountModel $accountModel;
    public function register(){
        $this->accountModel = new AccountModel();
    }
    public function getAccounts(): void{
        $page = (int) $this->getQuery('page');
        $resultPerPage = (int) $this->getQuery('resultPerPage');
        $username = $this->getQuery('username');

        $page = $page == 0 ? 1 : $page;
        $resultPerPage = $resultPerPage == 0 ? 20 : $resultPerPage;
        $numberOfPage = $this->accountModel->getNumberOfPage($resultPerPage);
        $accounts = [];
        if (!is_null($username)){
            $accounts = $this->accountModel->findByName($page, $resultPerPage, $username);
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
        $bodyData = Validate::getBodyData(['username','password']);
        $username = $bodyData['username'];
        $password = $bodyData['password'];
        if ($this->accountModel->addAccount($username, $password)){
            Response::sendJson("Add success");
        } else{
            Response::sendJson("Failed to Add!!");
        }
    }
    public function updateAccount(int $id){
        $bodyData = Validate::getBodyData(['username', 'password']);
        $username = $bodyData['username'];
        $password = $bodyData['password'];
        $account = $this->accountModel->getById($id);
        $account->setUsername($username);
        $account->setPassword($password);
        if ($this->accountModel->updateAccount($account)){
            Response::sendJson($account);
        }else{
            Response::sendJson("Fail to Update");
        }
    }
}
