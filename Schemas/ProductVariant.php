<?php

namespace Schemas;

use enums\ClothingSize;

class ProductVariant
{
    public int $id;
    public Product $product;
    public string $color;
    public ClothingSize $size;
    public int $quantity;
    public string $urlImage;
    public int $quantityPurchased;
}