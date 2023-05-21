<?php
namespace Controllers;

use Core\BaseController;
use Core\View;
use Middlewares\AuthMiddleware;
use Models\AccountModel;
use Models\ProductModel;
    {
        private ProductModel $productModel;
        public function register(): void
        {
            new AuthMiddleware();
            $this->productModel = new ProductModel();
        }

        public function AdminPage(): void
        {
            $action = $this->getQuery('action');
            if ($action == null) {
                $action = "home";
            }
            \Helper::println("You are in: ", $action);
            View::render("administrator");
        }

        private ProductModel $productModel;
        public function ManageProductPage():void {
            $products = $this->productModel->getProducts(1,10);
            View::renderWithoutLayout("manage-products",[
                "product"=>$products
            ]);
        }
    }
    
?>