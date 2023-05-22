<?php

namespace Models;

use Core\DB;
use Core\Response;
use enums\Gender;
use enums\ProductStatus;
use Schemas\Category;
use Schemas\Product;
use Schemas\TypeProduct;

class ProductModel {

    private function convertRowToProduct($row) {
        $product = new Product();
        $product->id = (int) $row['id_product'];
        $product->name = $row['productName'];
        $product->price = (int) $row['price'];
        $product->description = $row['description'];
        $product->material = $row['material'];
        $product->madeBy = $row['made_by'];
        $product->status = ProductStatus::from($row['status']);

        $typeProduct = new TypeProduct();
        $typeProduct->id = (int) $row['id_type_product'];
        $typeProduct->name = $row['typeProductName'];
        $typeProduct->gender = Gender::from($row['gender']);
        $typeProduct->category = new Category();
        $typeProduct->category->id = (int) $row['id_category'];
        $typeProduct->category->name = $row['categoryName'];

        $product->typeProduct = $typeProduct;
        return $product;
    }

    public function getNumberOfPage(int $resultsPerPage): int {
        $sqlCount = "SELECT count(1) FROM product";
        $resultCount = DB::getDB()->execute_query($sqlCount);
        DB::close();
        $row = $resultCount->fetch_array();
        $total = $row[0];
        return ceil($total/$resultsPerPage);
    }

    // conditions = [['column' => 'columnName', '$operation' => 'conditionName', 'value' => 'value']]
    // Example about conditions:
    // conditions = [['column' => 'name', '$operation' => 'LIKE', 'value' => 'King']]
    public function getNumberOfPageByConditions(
        int $resultsPerPage, string|null $name, int $type, int $category,
        int|null $priceMin, int|null $priceMax
    ): int {
        $sqlCount = "
            SELECT count(*) as total
            FROM product as p
            LEFT JOIN type_product tp on tp.id_type_product = p.id_type_product
            INNER JOIN category c on c.id_category = tp.id_category";
        $list_value = [];
        if ($name != null) {
            $sqlCount .= ' WHERE p.name LIKE ?';
            $list_value[] = "%" . $name . "%";
        }

        if ($type != 0) {
            // If array not empty
            if (!empty($list_value)) {
                $sqlCount .= ' AND tp.id_type_product = ? ';
            } else {
                $sqlCount .= ' WHERE tp.id_type_product = ?';
            }

            $list_value[] =  $type;
        }

        if ($category != 0) {
            // If array not empty
            if (!empty($list_value)) {
                $sqlCount .= ' AND c.id_category = ? ';
            } else {
                $sqlCount .= ' WHERE c.id_category = ?';
            }

            $list_value[] = $category;
        }

        if ($priceMin != null) {
            // If array not empty
            if (!empty($list_value)) {
                $sqlCount .= ' AND p.price >= ?';
            } else {
                $sqlCount .= ' WHERE p.price >= ?';
            }

            $list_value[] = $priceMin;
        }

        if ($priceMax != null) {
            // If array not empty
            if (!empty($list_value)) {
                $sqlCount .= ' AND p.price <= ?';
            } else {
                $sqlCount .= ' WHERE p.price <= ?';
            }

            $list_value[] = $priceMax;
        }

        $resultCount = DB::getDB()->execute_query($sqlCount, $list_value);
        DB::close();
        $row = $resultCount->fetch_array();
        $total = $row[0];
        return ceil($total/$resultsPerPage);
    }

    public function getProducts(int $page, int $resultsPerPage): array {
        $pageFirstResult = ($page-1) * $resultsPerPage; 
        $sqlGetProducts = "
            SELECT id_product, p.name as productName, price, 
                   description, material, made_by, status, p.id_type_product,
                   tp.name as typeProductName, c.id_category, gender, c.name as categoryName
            FROM product as p
            LEFT JOIN type_product tp on tp.id_type_product = p.id_type_product
            INNER JOIN category c on c.id_category = tp.id_category
            LIMIT $pageFirstResult,$resultsPerPage";
        $result = DB::getDB()->execute_query($sqlGetProducts);
        DB::close();

        $products = [];
        while ($row = $result->fetch_assoc()) {
            $product = $this->convertRowToProduct($row);
            $products[] = $product;
        }

        return $products;
    }

    public function getProductsByConditions(
        int $page, int $resultsPerPage, string|null $name, int $type, int $category,
        int|null $priceMin, int|null $priceMax
    ): array {
        $pageFirstResult = ($page-1) * $resultsPerPage;
        $sqlGetProducts = "
            SELECT id_product, p.name as productName, price, 
                   description, material, made_by, status, p.id_type_product,
                   tp.name as typeProductName, c.id_category, gender, c.name as categoryName
            FROM product as p
            LEFT JOIN type_product tp on tp.id_type_product = p.id_type_product
            INNER JOIN category c on c.id_category = tp.id_category";

        $list_value = [];
        if ($name != null) {
            $sqlGetProducts .= ' WHERE p.name LIKE ? ';
            $list_value[] = "%" . $name . "%";
        }

        if ($type != 0) {
            // If array not empty
            if (!empty($list_value)) {
                $sqlGetProducts .= ' AND tp.id_type_product = ? ';
            } else {
                $sqlGetProducts .= ' WHERE tp.id_type_product = ?';
            }

            $list_value[] =  $type;
        }

        if ($category != 0) {
            // If array not empty
            if (!empty($list_value)) {
                $sqlGetProducts .= ' AND c.id_category = ? ';
            } else {
                $sqlGetProducts .= ' WHERE c.id_category = ?';
            }

            $list_value[] = $category;
        }

        if ($priceMin != null) {
            // If array not empty
            if (!empty($list_value)) {
                $sqlGetProducts .= ' AND p.price >= ?';
            } else {
                $sqlGetProducts .= ' WHERE p.price >= ?';
            }

            $list_value[] = $priceMin;
        }

        if ($priceMax != null) {
            // If array not empty
            if (!empty($list_value)) {
                $sqlGetProducts .= ' AND p.price <= ?';
            } else {
                $sqlGetProducts .= ' WHERE p.price <= ?';
            }

            $list_value[] = $priceMax;
        }

        // Limit result per page
        $sqlGetProducts .= "\nLIMIT $pageFirstResult, $resultsPerPage";

        $result = DB::getDB()->execute_query($sqlGetProducts, $list_value);
        DB::close();

        $products = [];
        while ($row = $result->fetch_assoc()) {
            $product = $this->convertRowToProduct($row);
            $products[] = $product;
        }

        return $products;
    }

    public function getById(int $id): Product|null {
        $sql = "
        SELECT product.id_product,product.name as productName, product.price, product.description,
               product.material,product.material,product.made_by,product.status, type_product.id_type_product,
               type_product.name as typeProductName, type_product.gender,category.id_category,
               category.name as categoryName
        FROM product,type_product,category
        WHERE product.id_type_product = type_product.id_type_product 
              and category.id_category = type_product.id_category
              and product.id_product = ?
        ";
        $result = DB::getDB()->execute_query($sql, [$id]);
        DB::close();
        $product = null;
        if ($row = $result->fetch_assoc()) {
            $product = $this->convertRowToProduct($row);
        }
        return $product;
    }

    public function addProduct(Product $product): bool {
        $sql = "Insert into product(name, price, description, material, made_by, status, id_type_product)
                values (?, ?, ?, ?, ?, ?, ?)";
        $result = DB::getDB()->execute_query(
            $sql,
            [
                $product->name,
                $product->price,
                $product->description,
                $product->material,
                $product->madeBy,
                $product->status->value,
                $product->typeProduct->id
            ]
        );
        if (!$result)
            return false;

        if (DB::getDB()->insert_id)
            return true;
        DB::close();
        return false;
    }

    public function deleteById(int $id): bool {
        $sql = "DELETE FROM product WHERE id_product = ?";
        $result = DB::getDB()->execute_query($sql, [$id]);
        if (!$result)
            return false;
        if (DB::getDB()->affected_rows == -1) {
            return false;
        }
        return true;
    }

    public function updateById(Product $product): bool {
        $sql = "
            UPDATE product
            SET name = ?, price = ?, description = ?, material = ?, made_by = ?, status = ?, id_type_product = ?
            WHERE id_product = ?";
        $result = DB::getDB()->execute_query(
            $sql,
            [
                $product->name,
                $product->price,
                $product->description,
                $product->material,
                $product->madeBy,
                $product->status,
                $product->typeProduct->id,
                $product->id
            ]
        );
        if (!$result)
            return false;

        if (DB::getDB()->affected_rows > 0) {
            return true;
        }
        return false;
    }
}