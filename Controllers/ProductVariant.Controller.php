<?php

namespace Controllers;

use Core\BaseController;
use Core\Response;
use Core\Validate;
use enums\ClothingSize;
use enums\ProductStatus;
use Models\ProductVariantModel;
use Schemas\Product;
use Schemas\ProductVariant;
use Schemas\TypeProduct;

class ProductVariantController extends BaseController
{
    private ProductVariantModel $productVariantModel;
    public function register(): void
    {
        $this->productVariantModel = new ProductVariantModel();
    }

    public function getProductVariants(): void {
        $page = (int) $this->getQuery('page');
        $resultsPerPage = (int) $this->getQuery('resultsPerPage');

        $page = $page == 0 ? 1 : $page;
        $resultsPerPage = $resultsPerPage == 0 ? 20 : $resultsPerPage;

        $numberOfPage = $this->productVariantModel->getNumberOfPage($resultsPerPage);
        $products = $this->productVariantModel->getProductVariants($page, $resultsPerPage);
        Response::sendJson([
            'pagination' => [
                'currentPage' => $page,
                'numberOfPage' => $numberOfPage
            ],
            'productVariants' => $products,
        ]);
    }

    public function addProductVariant(): void
    {
        $body = Validate::getBodyData(['id_product', 'color', 'size', 'quantity', 'url_image']);
        $idProduct = (int) $body['id_product'];
        $color = $body['color'];
        $size = ClothingSize::tryFrom($body['size']);
        $quantity = (int) $body['quantity'];
        $urlImage = $body['url_image'];
        $quantity_purchased = 0;

        // Validate data
        if ($size === null) {
            Response::sendJson("Invalid clothing size", 404);
        }

        // Create object
        $productVariant = new ProductVariant();
        $product = new Product();
        $productVariant->product = $product;
        $productVariant->product->id = $idProduct;
        $productVariant->color = $color;
        $productVariant->size = $size;
        $productVariant->quantity = $quantity;
        $productVariant->urlImage = $urlImage;
        $productVariant->quantityPurchased = $quantity_purchased;

        if ($this->productVariantModel->addProductVariant($productVariant)) {
            Response::sendJson("Product variant added successfully");
        } else {
            Response::sendJson("Error adding product variant", 404);
        }
    }

    public function deleteById($id): void
    {
        if ($this->productVariantModel->deleteById($id)) {
            Response::sendJson("Product variant deleted successfully");
        } else {
            Response::sendJson("Failed to delete product variant: id = $id", 400);
        }
    }

    public function updateById($id): void
    {
        $body = Validate::getBodyData(['id_product', 'color', 'size', 'quantity', 'url_image']);
        $idProduct = (int) $body['id_product'];
        $color = $body['color'];
        $size = ClothingSize::tryFrom($body['size']);
        $quantity = (int) $body['quantity'];
        $urlImage = $body['url_image'];
        $quantity_purchased = 0;

        // Validate data
        if ($size === null) {
            Response::sendJson("Invalid clothing size", 404);
        }

        // Create object
        $productVariant = new ProductVariant();
        $product = new Product();
        $productVariant->product = $product;
        $productVariant->product->id = $idProduct;
        $productVariant->color = $color;
        $productVariant->size = $size;
        $productVariant->quantity = $quantity;
        $productVariant->urlImage = $urlImage;
        $productVariant->quantityPurchased = $quantity_purchased;

        if ($this->productVariantModel->updateById($productVariant)) {
            Response::sendJson("Product updated successfully");
        } else {
            Response::sendJson("Failed to update product: id = $id", 400);
        }
    }

}