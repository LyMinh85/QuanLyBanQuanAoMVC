<?php

namespace Controllers;

use Core\BaseController;
use Core\Response;
use Core\Validate;
use enums\ProductStatus;
use Middlewares\AuthMiddleware;
use Models\ProductModel;
use Schemas\Product;
use Schemas\TypeProduct;

class ProductController extends BaseController
{   
    private ProductModel $productModel;
    public function register(): void
    {
        $this->productModel = new ProductModel();
    }

    public function getProducts(): void
    {
        $page = (int) $this->getQuery('page');
        $resultsPerPage = (int) $this->getQuery('resultsPerPage');
        $name = $this->getQuery('name');
        $type = $this->getQuery('type'); // typeProductName
        $category = $this->getQuery('category');
        $priceRange = $this->getQuery('priceRange');

        // Default
        $page = $page == 0 ? 1 : $page;
        $resultsPerPage = $resultsPerPage == 0 ? 20 : $resultsPerPage;
        $priceMin = 0;
        $priceMax = null;

        // Validate price range
        // priceRange = 'min-max' => price >= min and price <= max
        // Example: priceRange = '100-10000' => price >= 100 and price <= max
        if ($priceRange != null) {
            $priceRangeArray = explode("-", $priceRange);

            if (isset($priceRangeArray[0])) {
                $priceMin = $priceRangeArray[0];
            }

            if (isset($priceRangeArray[1])) {
                $priceMax = $priceRangeArray[1];
            }

            Response::logger("Min", $priceMin);
            Response::logger("Max", $priceMax);
        }

        if ($name != null || $type != null || $category != null || $priceRange != null) {
            $numberOfPage = $this->productModel->getNumberOfPageByConditions(
                $resultsPerPage, $name, $type, $category, $priceMin, $priceMax
            );
            $products = $this->productModel->getProductsByConditions(
                $page, $resultsPerPage, $name, $type, $category, $priceMin, $priceMax
            );
        } else {
            $numberOfPage = $this->productModel->getNumberOfPage($resultsPerPage);
            $products = $this->productModel->getProducts($page, $resultsPerPage);
        }

        Response::sendJson([
            'pagination' => [
                'resultPerPage' => $resultsPerPage,
                'currentPage' => $page,
                'numberOfPage' => $numberOfPage
            ],
            'products' => $products,
        ]);
    }

    public function getById(int $id): void
    {
        $product = $this->productModel->getById($id);
        if (is_null($product)) {
            Response::sendJson("Not found", 404);
        } else {
            Response::sendJson($product);
        }
    }

    public function addProduct(): void
    {
        $body = Validate::getBodyData(['name', 'price', 'description', 'material', 'madeBy', 'status', 'idTypeProduct']);
        $name = $body['name'];
        $price = (int) $body['price'];
        $description = $body['description'];
        $material = $body['material'];
        $madeBy = $body['madeBy'];
        $status = ProductStatus::tryFrom((int) $body['status']);
        $idTypeProduct = (int) $body['idTypeProduct'];

        // Validate data
        if ($status === null) {
            Response::sendJson("Invalid productStatus", 404);
        }

        // Create object
        $product = new Product();
        $product->name = $name;
        $product->price = $price;
        $product->description = $description;
        $product->material = $material;
        $product->madeBy = $madeBy;
        $product->status = $status;
        $product->typeProduct = new TypeProduct();
        $product->typeProduct->id = $idTypeProduct;

        if ($this->productModel->addProduct($product)) {
            Response::sendJson("Product added successfully");
        } else {
            Response::sendJson("Error adding product", 404);
        }
    }

    public function deleteById($id): void
    {
        if ($this->productModel->deleteById($id)) {
            Response::sendJson("Product deleted successfully");
        } else {
            Response::sendJson("Failed to delete product: id = $id", 400);
        }
    }

    public function updateById($id): void
    {
        $body = Validate::getBodyData(['name', 'price', 'description', 'material', 'madeBy', 'status', 'idTypeProduct']);
        $name = $body['name'];
        $price = (int) $body['price'];
        $description = $body['description'];
        $material = $body['material'];
        $madeBy = $body['madeBy'];
        $status = ProductStatus::tryFrom((int) $body['status']);
        $idTypeProduct = (int) $body['idTypeProduct'];

        // Validate data
        if ($status === null) {
            Response::sendJson("Invalid productStatus", 404);
        }

        // Create object
        $product = new Product();
        $product->name = $name;
        $product->price = $price;
        $product->description = $description;
        $product->material = $material;
        $product->madeBy = $madeBy;
        $product->status = $status;
        $product->typeProduct = new TypeProduct();
        $product->typeProduct->id = $idTypeProduct;

        if ($this->productModel->updateById($product)) {
            Response::sendJson("Product updated successfully");
        } else {
            Response::sendJson("Failed to update product: id = $id", 400);
        }
    }
}
