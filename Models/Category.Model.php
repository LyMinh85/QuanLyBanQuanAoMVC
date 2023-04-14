<?php

namespace Models;

use Core\DB;
use Core\Response;
use Schemas\Category;

class CategoryModel {
    private function convertRowToCategory($row): Category {
        return new Category(
            $row["id_category"], 
            $row["name"],
        );
    }

    public function getNumberOfPage(int $resultsPerPage): int {
        $sqlCount = "SELECT count(1) FROM category";
        $resultCount = DB::getDB()->execute_query($sqlCount);
        $row = $resultCount->fetch_array();
        $total = $row[0];
        return ceil($total/$resultsPerPage);
    }

    public function getCategories(int $page, int $resultsPerPage): array {
        $pageFirstResult = ($page-1) * $resultsPerPage; 
        $sql = "SELECT * FROM category LIMIT $pageFirstResult, $resultsPerPage";
        $result = DB::getDB()->execute_query($sql);
        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $categories[] = $this->convertRowToCategory($row);
        }
        return $categories;
    }

    public function getById(int $id): Category|null {
        $sql = "SELECT * FROM category WHERE id_category = ?";
        $result = DB::getDB()->execute_query($sql, [$id]);
        if ($row = $result->fetch_assoc()) {
            return $this->convertRowToCategory($row);
        }
        return null;
    }

    public function addCategory(string $name): bool {
        $sql = "INSERT INTO category(name) values (?)";
        $result = DB::getDB()->execute_query($sql, [
            $name,
        ]);
        if (!$result)
            return false;
        
        if (DB::getDB()->insert_id) 
            return true;
        return false;
    }

    public function updateCategory(Category $category): bool {
        $sql = "UPDATE category SET name = ? WHERE id_category = ?";
        $result = DB::getDB()->execute_query($sql, [
            $category->getName(),
            $category->getId()
        ]);

        if (!$result) 
            return false;
        
        if (DB::getDB()->affected_rows > 0) {
            return true;
        }

        return false;
    }

    public function deleteById(int $categoryId): bool {
        $sql = "DELETE FROM category where id_category = ?";
        $result = DB::getDB()->execute_query($sql, [$categoryId]);
        if (!$result) 
            return false;

        $rowAffected = DB::getDB()->affected_rows;
        
        if ($rowAffected > 0) 
            return true;

        return false;
    }

    public function findByName(int $page, int $resultsPerPage, string $name): array {
        $pageFirstResult = ($page-1) * $resultsPerPage; 
        $sql = "SELECT * FROM category WHERE category.name LIKE ? LIMIT $pageFirstResult, $resultsPerPage";
        $result = DB::getDB()->execute_query($sql, ["%$name%"]);
        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $categories[] = $this->convertRowToCategory($row);
        }
        return $categories;
    }
}