<?php
namespace Models;
use Cassandra\Date;
use Core\DB;
use Schemas\Customer;
use function Sodium\add;

class CustomerModel{
    private function convertRowToCustomer($row): Customer{
        return new Customer(
            (int) $row['id_customer'],
            (int) $row['id_account'],
            $row['name'],
            $row['gender'],
            \DateTime::createFromFormat('Y-m-d', $row['birthday']),
            $row['phone'],
            $row['address']
        );
    }
    public function getCustomers(int $page, int $resultsPerPage): array{
        $pageFirstResult = ($page - 1) * $resultsPerPage;
        $sql = "SELECT * FROM customer LIMIT $pageFirstResult, $resultsPerPage";
        $result = DB::getDB()->execute_query($sql);
        $customers = [];
        while ($row = $result->fetch_assoc()) {
            $customers[] = $this->convertRowToCustomer($row);
        }
        return $customers;
    }
    public function getNumberPage(int $resultsPerPage): int{
        $sqlCount = "SELECT count(1) FROM customer";
        $resultCount = DB::getDB()->execute_query($sqlCount);
        $row = $resultCount->fetch_array();
        $total = $row[0];
        $numberOfPage = ceil($total/$resultsPerPage);
        return $numberOfPage;
    }

    public function getById(int $id): Customer|null{
        $sql = "SELECT *FROM customer WHERE id_customer=?";
        $result = DB::getDB()->execute_query($sql,[$id]);
        if ($row = $result->fetch_assoc()){
            return $this->convertRowToCustomer($row);
        }
        return null;
    }
    public function addCustomer(int $id_account,string $name, string $gender, \DateTime $birthday, string $phone, string $address): bool{
        $sql = "INSERT INTO customer(id_account,name, gender, birthday, phone, address) values (?,?,?,?,?,?)";
        $result = DB::getDB()->execute_query($sql, [$id_account,$name,$gender,$birthday->format('Y-m-d'), $phone,$address]);

        if (!$result){
            return false;
        }
        if (DB::getDB()->insert_id){
            return true;
        }
        return false;
    }

    public function updateCustomer(Customer $customer): bool{
        $sql = "UPDATE customer SET name = ?, gender = ?, birthday = ?, phone = ?, address = ? WHERE id_customer =?";
        $result = DB::getDB()->execute_query($sql, [
            $customer->name,
            $customer->gender,
            $customer->birthday->format('Y-m-d'),
            $customer->phone,
            $customer->address, $customer->id_customer,
        ]);
        if (!$result)
            return false;
        if (DB::getDB()->affected_rows > 0){
            return true;
        }
        return false;
    }
    public function deleteByID(int $id_custommer):bool{
        $sql ="DELETE FROM customer WHERE id_customer=?";
        $result = DB::getDB()->execute_query($sql,[$id_custommer]);
        if (!$result)
            return false;

        $rowAffected = DB::getDB()->affected_rows;
        if ($rowAffected > 0)
            return true;

        return false;
    }

    public function findByName(int $page, int $resultsPerPage, string $name): array{
        $pageFirstResult =  ($page - 1 ) * $resultsPerPage;
        $sql = "SELECT * FROM customer WHERE customer.name LIKE ? LIMIT $pageFirstResult, $resultsPerPage ";
        $result = DB::getDB()->execute_query($sql,["%$name%"]);
        $customers = [];
        while ($row = $result->fetch_assoc()){
            $customers[] = $this-> convertRowToCustomer($row);
        }
        return $customers;
    }
}