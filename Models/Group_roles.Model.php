<?php
namespace Models;

use Core\DB;
use Schemas\Group_roles;

class GroupRoles{
    private function convertRowToGroupRoles($row): Group_roles{
        return new Group_roles(
            (int) ['id_group_roles'],
            $row['name']
        );
    }
    public function getGroupRoles(int $page, int $resultPerPage):array{
        $pageFirstResult = ($page - 1) * $resultPerPage;
        $sql = "SELECT * FROM group_roles LIMIT $pageFirstResult, $resultPerPage";
        $result = DB::getDB()->execute_query($sql);
        $group_roles = [];
        while ($row = $result->fetch_assoc()){
            $group_roles[] = $this->convertRowToGroupRoles($row);
        }

        return $group_roles;
    }
    public function getNumberPage(int $resultsPerPage): int{
        $sqlCount = "SELECT count(1) FROM group_roles";
        $resultCount = DB::getDB()->execute_query($sqlCount);
        $row = $resultCount->fetch_array();
        $total = $row[0];
        $numberOfPage = ceil($total/$resultsPerPage);
        return $numberOfPage;
    }
    public function getById(int $id): Group_roles|null{
        $sql = "SELECT * FROM group_roles WHERE id_group_roles=?";
        $result = DB::getDB()->execute_query($sql,[$id]);
        if ($row = $result->fetch_assoc()){
            return $this->convertRowToGroupRoles($row);
        }
        return null;
    }
    public function addGroupRoles(string $name_group_role){
        $sql = "INSERT INTO group_roles(name) values (?)";
        $result = DB::getDB()->execute_query($sql, [$name_group_role]);
        if (!$result){
            return false;
        }
        if (DB::getDB()->insert_id){
            return true;
        }
        return false;
    }
    public function updateGroupRoles(Group_roles $group_roles): bool{
        $sql = "UPDATE group_roles SET name = ? WHERE id_group_roles";
        $result = DB::getDB()->execute_query($sql, [
            $group_roles->name_group_role
        ]);
        if (!$result){
            return false;
        }
        if (DB::getDB()->affected_rows > 0){
            return true;
        }
        return false;
    }
    public function deleteById(int $id){
        $sql = "DELETE FROM group_roles WHERE id_group_roles";
        $result = DB::getDB()->execute_query($sql, [$id]);
        if (!$result){
            return false;
        }

        $rowAffected = DB::getDB()->affected_rows;
        if ($rowAffected > 0){
            return true;
        }
        return false;
    }
    public function findByName(int $page, int $resultsPerPage, string $name){
        $pageFirstResult = ($page - 1) * $resultsPerPage;
        $sql = "SELECT * FROM group_roles WHERE group_roles.name LIKE ? LIMIT $pageFirstResult, $resultsPerPage";
        $result = DB::getDB()->execute_query($sql, ["%$name%"]);
        $group_roles = [];
        while ($row = $result->fetch_assoc()){
            $group_roles[] = $this-> convertRowToGroupRoles($row);
        }
        return $group_roles;
    }


}