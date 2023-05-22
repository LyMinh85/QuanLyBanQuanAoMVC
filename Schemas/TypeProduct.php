<?php

namespace Schemas;

use enums\Gender;

class TypeProduct
{
    public int $id;
    public string $name;
    public Category $category;
    public Gender $gender;

    // public function __construct(int $id, string $name, Category $category, Gender $gender){
    //     $this->id = $id;
    //     $this->name = $name;
    //     $this->category = $category;
    //     $this->gender = $gender; 
    // }
}