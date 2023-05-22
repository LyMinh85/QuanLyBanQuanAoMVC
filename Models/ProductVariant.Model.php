<?php

namespace Models;

use Core\DB;
use enums\ClothingSize;
use enums\Gender;
use enums\ProductStatus;
use Schemas\Category;
use Schemas\Product;
use Schemas\ProductVariant;
use Schemas\TypeProduct;

class ProductVariantModel
{
    public function convertRowToProductVariant($row): ProductVariant
    {
        $productVariant = new ProductVariant();
        $productVariant->id = (int) $row['id_product_variant'];
        $productVariant->color = $row['color'];
        $productVariant->size = ClothingSize::tryFrom($row['size']);
        $productVariant->quantity = (int) $row['quantity'];
        $productVariant->urlImage = $row['url_image'];
        $productVariant->quantityPurchased = (int) $row['quantity_purchased'];

        // Get product data
        $product = new Product();
        $product->id = (int) $row['id_product'];
        $product->name = $row['productName'];
        $product->price = (int) $row['price'];
        $product->description = $row['description'];
        $product->material = $row['material'];
        $product->madeBy = $row['made_by'];
        $product->status = ProductStatus::from($row['status']);

        // Get type product and category data
        $typeProduct = new TypeProduct();
        $typeProduct->id = (int) $row['id_type_product'];
        $typeProduct->name = $row['typeProductName'];
        $typeProduct->gender = Gender::from($row['gender']);
        $typeProduct->category = new Category();
        $typeProduct->category->id = (int) $row['id_category'];
        $typeProduct->category->name = $row['categoryName'];

        $product->typeProduct = $typeProduct;
        $productVariant->product = $product;
        return $productVariant;
    }

    public function getNumberOfPage(int $resultsPerPage): int
    {
        $sqlCount = "SELECT count(1) FROM product_variant";
        $resultCount = DB::getDB()->execute_query($sqlCount);
        DB::close();
        $row = $resultCount->fetch_array();
        $total = $row[0];
        return ceil($total / $resultsPerPage);
    }

    public function getProductVariants(int $page, int $resultsPerPage): array
    {
        $pageFirstResult = ($page - 1) * $resultsPerPage;
        $sqlGetProducts = "
            SELECT pv.id_product_variant, pv.id_product, pv.color, pv.size,
                   pv.quantity, pv.url_image, pv.quantity_purchased,
                   p.id_product, p.name as productName, price, 
                   description, material, made_by, status, p.id_type_product,
                   tp.name as typeProductName, c.id_category, gender, c.name as categoryName
            FROM product_variant as pv
            INNER JOIN product p on pv.id_product = p.id_product
            LEFT JOIN type_product tp on tp.id_type_product = p.id_type_product
            INNER JOIN category c on c.id_category = tp.id_category
            LIMIT $pageFirstResult,$resultsPerPage";
        $result = DB::getDB()->execute_query($sqlGetProducts);
        DB::close();

        $productVariants = [];
        while ($row = $result->fetch_assoc()) {
            $productVariants[] = $this->convertRowToProductVariant($row);
        }
        return $productVariants;
    }

    public function getById(int $id) {
        $sql = "
            SELECT pv.id_product_variant, pv.id_product, pv.color, pv.size,
                   pv.quantity, pv.url_image, pv.quantity_purchased,
                   p.id_product, p.name as productName, price, 
                   description, material, made_by, status, p.id_type_product,
                   tp.name as typeProductName, c.id_category, gender, c.name as categoryName
            FROM product_variant as pv
            INNER JOIN product p on pv.id_product = p.id_product
            LEFT JOIN type_product tp on tp.id_type_product = p.id_type_product
            INNER JOIN category c on c.id_category = tp.id_category
            WHERE p.id_product = ?
        ";
        $result = DB::getDB()->execute_query($sql, [$id]);
        DB::close();

        if ($row = $result->fetch_assoc()) {
            $product = $this->convertRowToProductVariant($row);
        }
        return $product;
    }

    public function getAllProductionVariantByIdProduct(int $id){
        $sql = "
            SELECT * FROM product_variant where product_variant.id_product = ? 
        ";

        $result = DB::getDB()->execute_query($sql,[$id]);
        DB::close();

        $listProductVariant = [];
        while ($row = $result->fetch_assoc()) {
            $productVariant = new ProductVariant();
            $productVariant->id = (int) $row['id_product_variant'];
            $productVariant->color = $row['color'];
            $productVariant->size = ClothingSize::tryFrom($row['size']);
            $productVariant->quantity = (int) $row['quantity'];
            $productVariant->urlImage = $row['url_image'];
            $productVariant->quantityPurchased = (int) $row['quantity_purchased'];
            $listProductVariant[] = $productVariant;
        }
        
        return $listProductVariant;
    }

    public function addProductVariant(ProductVariant $productVariant): bool {
        $sql = "Insert into product_variant(id_product, color, size, quantity, url_image, quantity_purchased)
                values (?, ?, ?, ?, ?, ?)";
        $result = DB::getDB()->execute_query(
            $sql,
            [
                $productVariant->product->id,
                $productVariant->color,
                $productVariant->size->value,
                $productVariant->quantity,
                $productVariant->urlImage,
                $productVariant->quantityPurchased
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
        $sql = "DELETE FROM product_variant WHERE id_product_variant = ?";
        $result = DB::getDB()->execute_query($sql, [$id]);
        if (!$result)
            return false;
        if (DB::getDB()->affected_rows == -1) {
            return false;
        }
        return true;
    }

    public function updateById(ProductVariant $productVariant): bool {
        $sql = "
            UPDATE product_variant
            SET id_product = ?, color = ?, size = ?, quantity = ?, url_image = ?
            WHERE id_product_variant = ?";
        $result = DB::getDB()->execute_query(
            $sql,
            [
                $productVariant->product->id,
                $productVariant->color,
                $productVariant->size->value,
                $productVariant->quantity,
                $productVariant->urlImage,
                $productVariant->id
            ]
        );
        if (!$result)
            return false;

        if (DB::getDB()->affected_rows > 0) {
            return true;
        }
        return false;
    }

    public function updateQuantity(int $id, int $quantity): bool {
        $sql = "
            UPDATE product_variant
            SET quantity = ?
            WHERE id_product_variant = ?";
        $result = DB::getDB()->execute_query($sql, [$quantity, $id]);
        if (!$result)
            return false;

        if (DB::getDB()->affected_rows > 0) {
            return true;
        }
        return false;
    }


}