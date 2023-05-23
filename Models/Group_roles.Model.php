<?php
namespace Models;

use Core\DB;
use Schemas\Group_roles;

class GroupRoles{
    private function convertRowToGroupRoles($row): Group_roles{
        return new Group_roles(
            (int) $row['id_group_roles'],
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

    public function getRoleInGroup($id){
        $sql = "
            SELECT * 
            FROM `roles_in_group` 
            WHERE `roles_in_group`.`id_group_role`= $id
        ";
        $result = DB::getDB()->query($sql);
        $roles = [];
        while ($row = $result->fetch_assoc()) {
            $roles[] = $row["id_role"];
        }

        return $roles;
    }

    private function getNewId(){
        $sql = "
            SELECT `group_roles`.`id_group_roles`
            FROM `group_roles`
            ORDER BY `group_roles`.`id_group_roles` DESC
            LIMIT 1
        ";
        $result = DB::getDB()->query($sql);
        
        while ($row = $result->fetch_assoc()) {
            $id = $row["id_group_roles"];
        }
        DB::close();
        return $id;
    }

    public function addGroupRoles(string $name_group_role,$listRole){
        $sql = "INSERT INTO group_roles(name) values (?)";
        $result = DB::getDB()->execute_query($sql, [$name_group_role]);

        $id = $this->getNewId();


        foreach ($listRole as $value) {
            $sql = "INSERT INTO `roles_in_group`(`id_role`, `id_group_role`) 
                    VALUES ('$value',$id)";
            $result = DB::getDB()->query($sql);
        }

        DB::close();
    }
    public function updateGroupRoles(Group_roles $group_roles,$listRole): bool{
        $sql = "UPDATE group_roles SET name = ? WHERE id_group_roles=?";
        $result = DB::getDB()->execute_query($sql, [
            $group_roles->name_group_role,
            $group_roles->id_group_roles
        ]);

        $sql = "DELETE FROM `roles_in_group` WHERE `roles_in_group`.`id_group_role`='$group_roles->id_group_roles'";
        DB::getDB()->query($sql);
        foreach ($listRole as $value) {
            $sql = "INSERT INTO `roles_in_group`(`id_role`, `id_group_role`) 
                    VALUES ('$value',$group_roles->id_group_roles)";
            $result = DB::getDB()->query($sql);
        }
        DB::close();
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