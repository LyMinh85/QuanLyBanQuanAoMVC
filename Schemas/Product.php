<?php

namespace Schemas;

use enums\ProductStatus;

class Product {
    public int $id;
    public string $name;
    public int $price;
    public string $description;
    public string $material;
    public string $madeBy;
    public ProductStatus $status;
    public TypeProduct $typeProduct;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getMaterial(): string
    {
        return $this->material;
    }

    /**
     * @param string $material
     */
    public function setMaterial(string $material): void
    {
        $this->material = $material;
    }

    /**
     * @return string
     */
    public function getMadeBy(): string
    {
        return $this->madeBy;
    }

    /**
     * @param string $madeBy
     */
    public function setMadeBy(string $madeBy): void
    {
        $this->madeBy = $madeBy;
    }

    /**
     * @return ProductStatus
     */
    public function getStatus(): ProductStatus
    {
        return $this->status;
    }

    /**
     * @param ProductStatus $status
     */
    public function setStatus(ProductStatus $status): void
    {
        $this->status = $status;
    }

}