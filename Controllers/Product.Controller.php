<?php

namespace Controllers;

use Core\BaseController;
use Core\Response;
use Core\Validate;
use Middlewares\AuthMiddleware;
use Models\ProductModel;
use Schemas\Product;

class ProductController extends BaseController
{   
    private ProductModel $productModel;
    public function register() 
    {
        $this->registerMiddleware(new AuthMiddleware());
        $this->productModel = new ProductModel();
    }

    public function getProducts()
    {
        // Cast to int if not is a number return 0
        $resultPerPage = 10;
        $page = (int) $this->getQuery("page");
        if ($page == 0) {
            $page = 1;
        }
        $numberOfPage = $this->productModel->getNumberOfPage($resultPerPage);
        $products = $this->productModel->getProducts($page, $resultPerPage);
        Response::sendJson([
            "pagination" => [
                "currentPage" => $page,
                "numberOfPage" => $numberOfPage
            ],
            "products" => $products
        ]);
    }

    public function getProduct(int $id)
    {
        $product = $this->productModel->getById($id);
        Response::logger($this->queries);
        Response::sendJson($product);
    }

    public function addProduct()
    {
        $bodyData = Validate::getBodyData(['name']);

        $product = new Product(1, $bodyData["name"]);
        if ($this->productModel->addProduct($product)) {
            $this->getProducts();
        } else {
            $this->getProducts();
        }
    }

    public function deleteProduct($id)
    {
        if ($this->productModel->deleteProduct($id)) {
            Response::sendJson("Delete success");
        } else {
            Response::sendJson("Failed to delete product: id = $id", 400);
        }
    }

    public function updateProduct($id)
    {
        $bodyData = Validate::getBodyData(['name']);

        $product = new Product($id, $bodyData['name']);
        if ($this->productModel->updateProduct($product)) {
            Response::sendJson("Update success");
        } else {
            Response::sendJson("Failed to update product: id = $id", 400);
        }
    }
}
