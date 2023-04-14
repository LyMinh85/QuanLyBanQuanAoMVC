<?php

namespace Models;

use Core\DB;
use Schemas\TypeProduct;

class TypeProductModel {
    private function convertRowToTypeProduct($row): TypeProduct {
        return new TypeProduct(
            $row['id_type_product'],
            $row['name'],
            $row['id_cateogry'],
            $row['gender']
        );
    }

    public function getTypeProducts()
    {
        $typeProducts = [];
        $sql = "Select * from type_product";
        $result = DB::getDB()->execute_query($sql);
        while ($row = $result->fetch_assoc()) {
            $typeProducts[] = $this->convertRowToTypeProduct($row);
        }
        return $typeProducts;
    }
}