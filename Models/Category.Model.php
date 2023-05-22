<?php

namespace Models;

use Core\DB;
use Core\Response;
use enums\Gender;
use Schemas\Category;
use Schemas\TypeProduct;

class CategoryModel {
   public function convertRowToCategory($row): Category {
       $category = new Category();
       $category->id = (int) $row['id_category'];
       $category->name = $row['name'];

       return $category;
   }

    public function getNumberOfPage(int $resultsPerPage): int {
        $sqlCount = "SELECT count(1) FROM category";
        $resultCount = DB::getDB()->execute_query($sqlCount);
        $row = $resultCount->fetch_array();
        $total = $row[0];
        $numberOfPage = ceil($total/$resultsPerPage);
        return $numberOfPage;
    }

    public function getCategoriesOnly(){
        $sql = "
            SELECT * FROM category
        ";
        $result = DB::getDB()->execute_query($sql);
        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $categories[] = $this->convertRowToCategory($row);
        }

        return $categories;
    }

    public function getCategories(int $page, int $resultsPerPage): array {
        $pageFirstResult = ($page-1) * $resultsPerPage; 
        $sql = "
            SELECT category.id_category, category.name as categoryName, id_type_product, type_product.name as typeProductName, gender
            FROM category 
            LEFT JOIN type_product ON category.id_category = type_product.id_category
            LIMIT $pageFirstResult, $resultsPerPage
        ";
        $result = DB::getDB()->execute_query($sql);
        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $categoryId = $row['id_category'];
            // Create a Category object for this row if it doesn't already exist
            if (!isset($categories[$categoryId])) {
                $category = new Category();
                $category->id = $categoryId;
                $category->name = $row['categoryName'];
                $category->typeProducts = [];
                $categories[$categoryId] = $category;
            } else {
                $category = $categories[$categoryId];
            }

            if (isset($row['id_type_product'])) {
                // Create a TypeProduct object for this category
                $typeProduct = new TypeProduct();
                $typeProduct->id = $row['id_type_product'];
                $typeProduct->name = $row['typeProductName'];
                $typeProduct->category = new Category();
                $typeProduct->category->id = $categoryId;
                $typeProduct->gender = Gender::from($row['gender']);
                $category->typeProducts[] = $typeProduct;
            }
        }
        // Convert the mof categories to a regular indexed array
        // array(1 => category1, 2 => category2) -> array(category1, category2)
        return array_values($categories);
    }

//    public function getById(int $id): Category|null {
//        $sql = "SELECT * FROM category WHERE id_category = ?";
//        $result = DB::getDB()->execute_query($sql, [$id]);
//        if ($row = $result->fetch_assoc()) {
//            return $this->convertRowToCategory($row);
//        }
//        return null;
//    }

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
            $category->name,
            $category->id
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
        if (DB::getDB()->affected_rows == -1) {
            return false;
        }
        return true;
    }

//    public function findByName(int $page, int $resultsPerPage, string $name): array {
//        $pageFirstResult = ($page-1) * $resultsPerPage;
//        $sql = "SELECT * FROM category WHERE category.name LIKE ? LIMIT $pageFirstResult, $resultsPerPage";
//        $result = DB::getDB()->execute_query($sql, ["N'%$name%'"]);
//        $categories = [];
//        while ($row = $result->fetch_assoc()) {
//            $categories[] = $this->convertRowToCategory($row);
//        }
//        return $categories;
//    }
}