<?php

namespace Models;

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

}