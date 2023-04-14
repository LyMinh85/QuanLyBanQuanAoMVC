<?php

namespace Schemas;

class TypeProduct {
    public int $id;
    public string $name;
    public int $idCategory;
    public string $gender;

    public function __construct(int $id, string $name, int $idCategory, string $gender) {
        $this->id = $id;
        $this->name = $name;
        $this->idCategory = $idCategory;
        $this->gender =$gender;
    }
}