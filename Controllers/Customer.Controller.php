<?php
namespace Controllers;

use Cassandra\Date;
use Core\BaseController;
use Core\Response;
use Core\Validate;
use Models\CustomerModel;

class CustomerController extends BaseController{
    private CustomerModel $customerModel;

    public function register(): void
    {
        $this->customerModel =  new CustomerModel();
    }
    public function getCustomers(): void{
        $page = (int) $this->getQuery('page');
        $resultPerPage = (int) $this->getQuery('resultPerPage');
        $name = $this->getQuery('name');

        $page = $page == 0 ? 1 : $page;
        $resultPerPage = $resultPerPage == 0 ? 20 : $resultPerPage;
        $numberOfPage = $this->customerModel->getNumberPage($resultPerPage);
        $customers = [];
        if (!is_null($name)){
            $customers= $this->customerModel->findByName($page, $resultPerPage, $name);
        }
        else{
            $customers = $this->customerModel->getCustomers($page, $resultPerPage);
        }
        Response::sendJson([
            'pagination' => [
                'currentPage' => $page,
                'numberOfPage' => $numberOfPage
            ],
            'customers' => $customers,
        ]);


    }

    public function getById(int $id){
        $customer = $this->customerModel->getById($id);
        if (is_null($customer)){
            Response::sendJson("Not Found");
        }else{
            Response::sendJson($customer);
        }

    }
    public function deleteById(int $id){
        if ($this->customerModel->deleteByID($id)){
            Response::sendJson("Deleted Customer Successfully");
        }else{
            Response::sendJson("Failed to Delete!");
        }
    }

    public function addCustomer(){
        $bodyData = Validate::getBodyData(['id_account','name','gender','birthday','phone','address']);
        $id_account = $bodyData['id_account'];
        $name = $bodyData['name'];
        $gender = $bodyData['gender'];
        $input_birthday = $bodyData['birthday'];
        $birthday = \DateTime::createFromFormat('d/m/Y',$input_birthday);
        $phone = $bodyData['phone'];
        $address = $bodyData['address'];
        if ($this->customerModel->addCustomer($id_account ,$name, $gender,$birthday, $phone, $address)){
            Response::sendJson("Add Customer Successfully");
        }else{
            Response::sendJson("Failed to Add!");
        }
    }

    public function updateCustomer(int $id){
        $bodyData = Validate::getBodyData(['name','gender','birthday','phone','address']);
        $name = $bodyData['name'];
        $gender = $bodyData['gender'];
        $input_birthday = $bodyData['birthday'];
        $birthday = \DateTime::createFromFormat('d/m/Y',$input_birthday);
        $phone = $bodyData['phone'];
        $address = $bodyData['address'];
        $customer = $this->customerModel->getById($id);
        $customer->name = $name;
        $customer->gender = $gender;
        $customer->birthday = $birthday;
        $customer->phone = $phone;
        $customer->address = $address;
        if ($this->customerModel->updateCustomer($customer)){
            Response::sendJson($customer);
        }else{
            Response::sendJson("Failed to Add!");
        }
    }
}
