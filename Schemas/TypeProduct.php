<?php

namespace Schemas;

use enums\Gender;

class TypeProduct
{
    public int $id;
    public string $name;
    public Category $category;
    public Gender $gender;

}