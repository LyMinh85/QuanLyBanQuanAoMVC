<?php
namespace Models;

use Cassandra\Date;
use Core\DB;
use Core\Response;
use Schemas\Order;

class OrderModel{
    private function convertRowToOrder($row): Order{
        return new Order(
            (int) $row['id_order'],
            (int) $row['id_account'],
            $row['address'],
            \DateTime::createFromFormat('Y-m-d',$row['create_date']),
            \DateTime::createFromFormat('Y-m-d',$row['receive_date']),
            $row['method_of_payment'],
            (int) $row['sum_price'],
            (int) $row['status']
        );
    }
    public function getOrders(int $page, int $resultsPerPage): array{
        $pageFirstResult = ($page - 1) * $resultsPerPage;
        $sql = "SELECT * FROM `order` LIMIT $pageFirstResult, $resultsPerPage";
        $result = DB::getDB()->execute_query($sql);
        $orders = [];
        while ($row = $result->fetch_assoc()){
            $orders[] = $this->convertRowToOrder($row);
        }
        return $orders;
    }
    public function getNumberPage(int $resultsPerPage): int{
        $sqlCount = "SELECT count(1) FROM `order`";
        $resultCount = DB::getDB()->execute_query($sqlCount);
        $row = $resultCount->fetch_array();
        $total = $row[0];
        $numberOfPage = ceil($total/$resultsPerPage);
        return $numberOfPage;
    }
    public function getById(int $id): Order|null{
        $sql = "SELECT *FROM `order` WHERE id_order=?";
        $result = DB::getDB()->execute_query($sql,[$id]);
        if ($row = $result->fetch_assoc()){
            return $this->convertRowToOrder($row);
        }
        return null;
    }
    public function addOrder(int $id_customer, string $address, \DateTime $create_date, \DateTime $receive_date, string $method_of_payment, int $sum_price, int $status ):bool{
        $sql = "INSERT INTO `order`(id_customer, address, create_date, receive_date, method_of_payment, sum_price, status) values (?,?,?,?,?,?,?)";
        $result = DB::getDB()->execute_query($sql, [$id_customer,$address, $create_date->format('Y-m-d'),$receive_date->format('Y-m-d'),$method_of_payment,$sum_price,$status]);
        if (!$result){
            return false;
        }
        if (DB::getDB()->insert_id){
            return true;
        }
        return false;
    }
    public function updateOrder(Order $order): bool{
        $sql = "UPDATE `order` SET address= ?, create_date = ?, receive_date = ?, method_of_payment = ?, sum_price = ?, status = ? WHERE id_order = ?";
        $result = DB::getDB()->execute_query($sql,[
            $order->address,
            $order->create_date->format('Y-m-d'),
            $order->receive_date->format('Y-m-d'),
            $order->method_of_payment,
            $order->sum_price,
            $order->status,
            $order->id_order
        ]);
        if (!$result)
            return false;
        if (DB::getDB()->affected_rows > 0){
            return true;
        }
        return false;
    }
    public function deleteByID(int $id_order):bool{
        $sql ="DELETE FROM `order` WHERE id_order=?";
        $result = DB::getDB()->execute_query($sql,[$id_order]);
        if (!$result)
            return false;

        $rowAffected = DB::getDB()->affected_rows;
        if ($rowAffected > 0)
            return true;

        return false;
    }
    public function findByReceiveDate(int $page, int $resultsPerPage, \DateTime $receive_date): array{
        $pageFirstResult =  ($page - 1 ) * $resultsPerPage;
        $sql = "SELECT * FROM `order` WHERE `order`.receive_date = ? LIMIT $pageFirstResult, $resultsPerPage ";
        $date_time = $receive_date->format('Y-m-d');
        $result = DB::getDB()->execute_query($sql,["$date_time"]);
        $orders = [];
        while ($row = $result->fetch_assoc()){
            $orders[] = $this-> convertRowToOrder($row);
        }
        return $orders;
    }

    public function findByCreateDate(int $page, int $resultsPerPage, \DateTime $create_date): array{
        $pageFirstResult =  ($page - 1 ) * $resultsPerPage;
        $sql = "SELECT * FROM `order` WHERE `order`.create_date = ? LIMIT $pageFirstResult, $resultsPerPage ";
        $date_time = $create_date->format('Y-m-d');
        $result = DB::getDB()->execute_query($sql,["$date_time"]);
        $orders = [];
        while ($row = $result->fetch_assoc()){
            $orders[] = $this-> convertRowToOrder($row);
        }
        return $orders;
    }
    public function findByCustomerName(int $page, int $resultsPerPage, string $name){
        $pageFirstResult = ($page - 1) * $resultsPerPage;
        $sql = "SELECT * FROM `order` INNER JOIN customer c on `order`.id_customer = c.id_customer WHERE c.name LIKE ?";
        $result = DB::getDB()->execute_query($sql, ["%$name%"]);
        $orders = [];
        while ($row = $result->fetch_assoc()){
            $orders[] = $this->convertRowToOrder($row);
        }
        return $orders;
    }

}