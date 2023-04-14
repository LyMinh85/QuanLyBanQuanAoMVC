<?php

namespace Models;

use Core\DB;
use Schemas\Product;

class ProductModel {

    private function convertRowToProduct($row) {
        return new Product($row["id_product"], $row["name"]);
    }

    public function getNumberOfPage(int $resultsPerPage): int {
        $sqlCount = "SELECT count(1) FROM product";
        $resultCount = DB::getDB()->execute_query($sqlCount);
        $row = $resultCount->fetch_array();
        $total = $row[0];
        $numberOfPage = ceil($total/$resultsPerPage);
        return $numberOfPage;
    }

    public function getProducts(int $page, int $resultsPerPage): array {
        $products = [];

        $pageFirstResult = ($page-1) * $resultsPerPage; 
        $sqlGetProducts = "SELECT * FROM product LIMIT $pageFirstResult,$resultsPerPage";
        $result = DB::getDB()->execute_query($sqlGetProducts);

        DB::close();
        while ($row = $result->fetch_assoc()) {
            $products[] = $this->convertRowToProduct($row);
        }

        return $products;
    }

    public function getById(int $id): Product|null {
        $result = DB::getDB()->execute_query(
            "SELECT * FROM product WHERE id_product = ?", 
            [$id]
        );
        DB::close();
        $product = null;
        if ($row = $result->fetch_assoc()) {
            $product = $this->convertRowToProduct($row);
        }
        return $product;
    }

    public function addProduct(Product $product): bool {
        $sql = "Insert into product (name, price, id_category, id_type_product)
                values (?, 0, 1, 1)";
        $result = DB::getDB()->execute_query($sql, [$product->name]);
        DB::close();
        return $result;
    }

    public function deleteProduct(int $id): bool {
        $sql = "DELETE FROM product WHERE id_product = ?";
        $result = DB::getDB()->execute_query($sql, [$id]);
        DB::close();
        return $result;
    }

    public function updateProduct(Product $product): bool {
        $sql = "UPDATE product SET name = ? WHERE id_product = ?";
        $result = DB::getDB()->execute_query($sql, [$product->name, $product->id]);
        DB::close();
        return $result;
    }
}