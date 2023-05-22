<?php
namespace Models;

use Core\DB;

use Schemas\Role;

class RoleModel{
    private function convertRowToRoles($row): Role{
        return new Role(
            (int) $row['id_role'],
            $row['name'],
        );
    }
    public function getRoles():array{
        // $pageFirstResult = ($page - 1) * $resultPerPage;
        $sql = "SELECT * FROM role";
        $result = DB::getDB()->execute_query($sql);
        $roles = [];
        while ($row = $result->fetch_assoc()){
            $roles[] = $this->convertRowToRoles($row);
        }
        return $roles;
    }

    public function getNumberPage(int $resultsPerPage): int{
        $sqlCount = "SELECT count(1) FROM role";
        $resultCount = DB::getDB()->execute_query($sqlCount);
        $row = $resultCount->fetch_array();
        $total = $row[0];
        $numberOfPage = ceil($total/$resultsPerPage);
        return $numberOfPage;
    }
    public function getById(int $id): Role|null{
        $sql = "SELECT * FROM role WHERE id_role=?";
        $result = DB::getDB()->execute_query($sql,[$id]);
        if ($row = $result->fetch_assoc()){
            return $this->convertRowToRoles($row);
        }
        return null;
    }
    public function addRoles(string $name_role){
        $sql = "INSERT INTO role(name) values (?)";
        $result = DB::getDB()->execute_query($sql, [$name_role]);
        if (!$result){
            return false;
        }
        if (DB::getDB()->insert_id){
            return true;
        }
        return false;
    }
    public function updateGroupRoles(Role $roles): bool{
        $sql = "UPDATE role SET name = ? WHERE id_role";
        $result = DB::getDB()->execute_query($sql, [
            $roles->name_role
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
        $sql = "DELETE FROM role WHERE id_role";
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
        $sql = "SELECT * FROM role WHERE role.name LIKE ? LIMIT $pageFirstResult, $resultsPerPage";
        $result = DB::getDB()->execute_query($sql, ["%$name%"]);
        $roles = [];
        while ($row = $result->fetch_assoc()){
            $roles[] = $this-> convertRowToRoles($row);
        }
        return $roles;
    }
}
?>