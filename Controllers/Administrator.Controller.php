<?php
namespace Controllers;

use Core\BaseController;
use Core\View;
use enums\ProductStatus;
use Middlewares\AuthMiddleware;
use Models\AccountModel;
use Models\CategoryModel;
use Models\ProductModel;
use Models\ProductVariantModel;
use Models\TypeProductModel;
use Schemas\Product;
use Schemas\TypeProduct;
    class AdministratorController extends BaseController
    {
        private ProductModel $productModel;
        private ProductVariantModel $productVariantModel;
        private CategoryModel $categoryModel;
        private TypeProductModel $typeProductModel;
        public function register(): void
        {
            new AuthMiddleware();
            $this->productModel = new ProductModel();
            $this->productVariantModel = new ProductVariantModel();
            $this->categoryModel = new CategoryModel();
            $this->typeProductModel = new TypeProductModel();
        }

        public function AdminPage(): void
        {
            $action = $this->getQuery('action');
            if ($action == null) {
                $action = "home";
            }

            View::render("administrator");
        }

        public function ManageProductPage():void {
            $products = $this->productModel->getProducts(1,10);

            View::renderWithoutLayout("manage-in-admin/manage-products",[
                "products"=>$products
            ]);
        }

        public function ProductPage():void {
            // print_r($id);
            $id = $this->getQuery('id');
            // print_r($id);
            $products = $this->productModel->getById($id);
            $productVariants = $this->productVariantModel->getAllProductionVariantByIdProduct($id);   
            $categories = $this->categoryModel->getCategories(1,10);
            $types = $this->typeProductModel->getTypeProducts();

            View::renderWithoutLayout("manage-in-admin/product-page",[
                "products"=>$products,
                "productVariants"=>$productVariants,
                "categories"=>$categories,
                "types"=>$types
            ]);
        }

        public function Add(){
            $mode = $_POST["mode"];

            if($mode == "Product"){
                if($_POST["name"] == "") die("false + name + Please enter the name of product!");
                // if($price == "") die("false + price + Please enter the price of product!");
                // if($material == "") die("false + material + Please enter the material of product!");
                // if($made_by == "") die("false + made_by + Please fill up made by!");
                // if($colors == "") die("false + color0 + Please enter the color of product");
                // if($quantities == "") die("false + quantity0 + Please enter the quantities of product");

                $product = new Product();
                $product->name = $_POST["name"];
                $product->material = $_POST["material"];
                $product->madeBy = $_POST["made_by"];
                $product->price = (int)$_POST["price"];
                $product->description = $_POST["description"];
                $product->status = ProductStatus::from($_POST['status']);
                $product->typeProduct = new TypeProduct();
                $product->typeProduct->id = $_POST["type"];
                print_r($product);

            }
        }
    }
    
?>