<?php

namespace Controllers;

use Core\BaseController;
use Core\Response;
use Core\Validate;
use Middlewares\AuthMiddleware;
use Models\Product;

class ProductController extends BaseController
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware());
    }

    public function getAll()
    {
        $products = Product::getAll();
        Response::sendJson($products);
    }

    public function getProduct(int $id)
    {
        $product = Product::getProduct($id);
        Response::logger($this->queries);
        Response::sendJson($product);
    }

    public function addProduct()
    {
        $bodyData = Validate::getBodyData(['name']);

        $product = new Product(1, $bodyData["name"]);
        if (Product::addProduct($product)) {
            $this->getAll();
        } else {
            $this->getAll();
        }
    }

    public function deleteProduct($id)
    {
        if (Product::deleteProduct($id)) {
            Response::sendJson("Delete success");
        } else {
            Response::sendJson("Failed to delete product: id = $id", 400);
        }
    }

    public function updateProduct($id)
    {
        $bodyData = Validate::getBodyData(['name']);

        $product = new Product($id, $bodyData['name']);
        if (Product::updateProduct($product)) {
            Response::sendJson("Update success");
        } else {
            Response::sendJson("Failed to update product: id = $id", 400);
        }
    }
}
