<?php
namespace Controllers;

use Core\BaseController;
use Core\View;
use Models\ProductModel;
    class AdministratorController extends BaseController
    {
        public function register(): void
        {
            $this->productModel = new ProductModel();
        
        }

        public function AdminPage(): void
        {
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