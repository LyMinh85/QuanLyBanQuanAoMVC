<?php

namespace Models;

use Core\DB;
use Schemas\Account;

class AccountModel {

    private function convertRowToAccount($row): Account{
        return new Account(
            $row["id_account"],
            $row["username"],
            $row["password"],
            (int) $row["id_group_roles"],
            (int) $row['id_customer'],
            $row['name'],
            $row['gender'],
            \DateTime::createFromFormat('Y-m-d', $row['birthday']),
            $row['phone'],
            $row['address'],
            $row['email']
        );
    }

    public function getAccounts(int $page, int $resultPerPage): array{
        $pageFirstResult = ($page - 1) * $resultPerPage;
        $sql = "SELECT * FROM account LIMIT $pageFirstResult, $resultPerPage";
        $result = DB::getDB()->execute_query($sql);
        $accounts = [];
        while ($row = $result->fetch_assoc()) {
            $accounts[] = $this->convertRowToAccount($row);
        }
        return $accounts;
    }
    public function getNumberOfPage(int $resultsPerPage):int {
        $sqlCount = "SELECT count(1) from account";
        $resultCount = DB::getDB()->execute_query($sqlCount);
        $row = $resultCount->fetch_array();
        $total = $row[0];
        $numberOfPage = ceil($total/$resultsPerPage);
        return $numberOfPage;
    }

    public function getById(int $id): Account|null{
        $sql = "SELECT * FROM account WHERE id_account = ?";
        $result = DB::getDB()->execute_query($sql,[$id]);
        if ($row = $result->fetch_assoc()){
            return $this->convertRowToAccount($row);
        }
        return null;
    }

    public function  addAccount(string $username, string $password, string $name, string $gender,
                                \DateTime $birthday, string $phone, string $address, string $email): bool{
        $sql = "INSERT INTO account(username, password, name, gender, birthday, phone, address, email) values (?, ?, ?, ?, ?, ?, ?, ?)";
        $result = DB::getDB()-> execute_query($sql, [$username, $password, $name,$gender,$birthday->format('Y-m-d'), $phone,$address, $email]);
        if (!$result)
            return false;

        if (DB::getDB()->insert_id)
            return true;
        return false;
    }

    public function  updateAccount(Account $account): bool{
        $sql = "UPDATE account SET username = ?, password = ?, name = ?, gender = ?, birthday = ?, phone = ?, address = ?, email = ? WHERE id_account = ?";
        $result = DB::getDB()->execute_query($sql, [
            $account->username,
            $account->password,
            $account->name,
            $account->gender,
            $account->birthday->format('Y-m-d'),
            $account->phone,
            $account->address,
            $account->email,
            $account->id_account
        ]);
        if (!$result)
            return false;

        if (DB::getDB()->affected_rows > 0){
            return true;
        }

        return false;

    }

    public function deleteById(int $id_account): bool{
        $sql = "DELETE FROM account WHERE id_account = ?";
        $result = DB::getDB()->execute_query($sql,[$id_account]);
        if (!$result)
            return false;

        $rowAffected = DB::getDB()->affected_rows;
        if ($rowAffected > 0)
            return true;

        return false;
    }

    public function findByName(int $page, int $resultsPerPage, string $name): array{
        $pageFirstResult =  ($page - 1 ) * $resultsPerPage;
        $sql = "SELECT * FROM account WHERE account.name LIKE ? LIMIT $pageFirstResult, $resultsPerPage ";
        $result = DB::getDB()->execute_query($sql,["%$name%"]);
        $customers = [];
        while ($row = $result->fetch_assoc()){
            $customers[] = $this-> convertRowToAccount($row);
        }
        return $customers;
    }


}
