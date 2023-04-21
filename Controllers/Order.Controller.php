<?php
namespace Controllers;

use Core\BaseController;
use Core\Response;
use Core\Validate;
use Models\OrderModel;

class OrderController extends BaseController{
    private OrderModel $orderModel;
    public function register(): void
    {
        $this->orderModel = new OrderModel();
    }
    public function getOrders(): void{
        $page = (int) $this->getQuery('page');
        $resultPerPage = (int) $this->getQuery('resultPerPage');
        $create_date = $this->getQuery('create_date');
        $receive_date = $this->getQuery('receive_date');
        $customer_name = $this->getQuery('customer_name');

        $page = $page == 0 ? 1 : $page;
        $resultPerPage = $resultPerPage == 0 ? 20 : $resultPerPage;
        $numberOfPage = $this->orderModel->getNumberPage($resultPerPage);
        $orders = [];
        if (!is_null($customer_name)){
            $orders= $this->orderModel->findByCustomerName($page, $resultPerPage, $customer_name);
        } else if (!is_null($create_date)){
            $create_date_time = \DateTime::createFromFormat('d/m/Y',$create_date);
            $orders= $this->orderModel->findByCreateDate($page, $resultPerPage, $create_date_time);
        } else if (!is_null($receive_date)){
            $receive_date_time = \DateTime::createFromFormat('d/m/Y',$receive_date);
            $orders= $this->orderModel->findByReceiveDate($page, $resultPerPage, $receive_date_time);
        } else {
            $orders = $this->orderModel->getOrders($page, $resultPerPage);
        }

        Response::sendJson([
            'pagination' => [
                'currentPage' => $page,
                'numberOfPage' => $numberOfPage
            ],
            'orders' => $orders,
        ]);
    }
    public function getById(int $id){
        $order = $this->orderModel->getById($id);
        if (is_null($order)){
            Response::sendJson("Not Found");
        }else{
            Response::sendJson($order);
        }
    }

    public function deleteById(int $id){
        if ($this->orderModel->deleteByID($id)){
            Response::sendJson("Deleted Order Successfully");
        }else{
            Response::sendJson("Failed to Delete!");
        }
    }
    public function addOrder(){
        $bodyData = Validate::getBodyData(['id_customer','address','create_date','receive_date','method_of_payment','sum_price','status']);
        $id_customer = $bodyData['id_customer'];
        $address =$bodyData['address'];
        $input_create_date = $bodyData['create_date'];
        $create_date = \DateTime::createFromFormat('d/m/Y',$input_create_date);
        $input_receive_date = $bodyData['receive_date'];
        $receive_date = \DateTime::createFromFormat('d/m/Y',$input_receive_date);
        $method_of_payment = $bodyData['method_of_payment'];
        $sum_price = $bodyData['sum_price'];
        $status = $bodyData['status'];
        if ($this->orderModel->addOrder($id_customer, $address, $create_date, $receive_date,$method_of_payment,$sum_price,$status)){
                Response::sendJson("Add Order Successfully");
        }else{
            Response::sendJson("Failed to Add");
        }

    }
    public function updateOrder(int $id){
        $bodyData = Validate::getBodyData(['address','create_date','receive_date','method_of_payment','sum_price','status']);
        $address =$bodyData['address'];
        $input_create_date = $bodyData['create_date'];
        $create_date = \DateTime::createFromFormat('d/m/Y',$input_create_date);
        $input_receive_date = $bodyData['receive_date'];
        $receive_date = \DateTime::createFromFormat('d/m/Y',$input_receive_date);
        $method_of_payment = $bodyData['method_of_payment'];
        $sum_price = $bodyData['sum_price'];
        $status = $bodyData['status'];
        $order = $this->orderModel->getById($id);
        $order->address = $address;
        $order->create_date = $create_date;
        $order->receive_date = $receive_date;
        $order->method_of_payment = $method_of_payment;
        $order->sum_price = $sum_price;
        $order->status = $status;

        if ($this->orderModel->updateOrder($order)){
            Response::sendJson("Update Order Successfully");
        }else{
            Response::sendJson("Failed to Update");
        }
    }
}