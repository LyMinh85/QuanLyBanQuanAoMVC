<?php

namespace Models;

use Core\DB;

class Product {
    public $id;
    public $name;

    public function __construct($id, $name) {
        $this->id = $id;
        $this->name = $name;
    }
    private static function convertRowToProduct($row) {
        return new Product($row["id_product"], $row["name"]);
    }

    public static function getAll(): array {
        $products = [];
        $sql = "SELECT * FROM product";
        $result = DB::getDB()->execute_query($sql);
        DB::close();
        while ($row = $result->fetch_assoc()) {
            $products[] = Product::convertRowToProduct($row);
        }
        return $products;
    }

    public static function getProduct(int $id): Product {
        $result = DB::getDB()->execute_query(
            "SELECT * FROM product WHERE id_product = ?", 
            [$id]
        );
        DB::close();
        $product = null;
        if ($row = $result->fetch_assoc()) {
            $product = Product::convertRowToProduct($row);
        }
        return $product;
    }

    public static function addProduct(Product $product): bool {
        $sql = "Insert into product (name, price, id_category, id_type_product)
                values (?, 0, 1, 1)";
        $result = DB::getDB()->execute_query($sql, [$product->name]);
        DB::close();
        return $result ? true : false;
    }

    public static function deleteProduct(int $id): bool {
        $sql = "DELETE FROM product WHERE id_product = ?";
        $result = DB::getDB()->execute_query($sql, [$id]);
        DB::close();
        return $result ? true : false;
    }

    public static function updateProduct(Product $product): bool {
        $sql = "UPDATE product SET name = ? WHERE id_product = ?";
        $result = DB::getDB()->execute_query($sql, [$product->name, $product->id]);
        DB::close();
        return $result ? true : false;
    }
}