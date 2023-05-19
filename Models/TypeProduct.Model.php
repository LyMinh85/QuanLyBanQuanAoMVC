<?php

namespace Models;

use Core\DB;
use enums\Gender;
use Schemas\Category;
use Schemas\TypeProduct;

class TypeProductModel {
    private string $DATABASE_NAME = "type_product";
    public function convertRowToTypeProduct($row): TypeProduct {
        $typeProduct = new TypeProduct();
        $typeProduct->id = (int) $row['id_type_product'];
        $typeProduct->name = $row['name'];
        $typeProduct->category = new Category();
        $typeProduct->category->id = (int) $row['id_category'];
        $typeProduct->gender = Gender::from($row['gender']);
        return $typeProduct;
    }

    public function getTypeProducts(): array
    {
        $typeProducts = [];
        $sql = "Select * from $this->DATABASE_NAME";
        $result = DB::getDB()->execute_query($sql);
        DB::close();
        while ($row = $result->fetch_assoc()) {
            $typeProducts[] = $this->convertRowToTypeProduct($row);
        }
        return $typeProducts;
    }

    public function getById(int $id): TypeProduct|null {
        $sql = "SELECT * FROM $this->DATABASE_NAME where id_type_product = ?";
        $result = DB::getDB()->execute_query($sql, [$id]);
        DB::close();
        if ($row = $result->fetch_assoc()) {
            return $this->convertRowToTypeProduct($row);
        }
        return null;
    }

    public function addOne(TypeProduct $typeProduct): bool {
        $sql = "INSERT INTO $this->DATABASE_NAME(name, id_category, gender) values (?, ?, ?)";
        $result = DB::getDB()->execute_query($sql, [
            $typeProduct->name,
            $typeProduct->category->id,
            $typeProduct->gender->value,
        ]);
        if (!$result)
            return false;

        if (DB::getDB()->insert_id)
            return true;
        DB::close();
        return false;
    }

    public function deleteById(int $id): bool {
        $sql = "DELETE FROM $this->DATABASE_NAME WHERE id_type_product = ?";
        $result = DB::getDB()->execute_query($sql, [$id]);
        if (!$result)
            return false;
        if (DB::getDB()->affected_rows == -1) {
            return false;
        }
        return true;
    }

    public function updateById(TypeProduct $typeProduct): bool {
        $sql = "UPDATE $this->DATABASE_NAME SET name = ?, id_category = ?, gender = ? WHERE id_type_product = ?";
        $result = DB::getDB()->execute_query($sql, [$typeProduct->name, $typeProduct->idCategory, $typeProduct->gender, $typeProduct->id]);
        if (!$result)
            return false;

        if (DB::getDB()->affected_rows > 0) {
            return true;
        }
        return false;
    }

    public function findByName(int $page, int $resultsPerPage, string $name): array {
        $pageFirstResult = ($page-1) * $resultsPerPage;
        $sql = "SELECT * FROM $this->DATABASE_NAME WHERE name LIKE ? LIMIT $pageFirstResult, $resultsPerPage";
        $result = DB::getDB()->execute_query($sql, ["N'%$name%'"]);
        $typeProducts = [];
        while ($row = $result->fetch_assoc()) {
            $typeProducts[] = $this->convertRowToTypeProduct($row);
        }
        return $typeProducts;
    }
}