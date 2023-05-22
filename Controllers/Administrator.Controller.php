<?php
namespace Controllers;

use Core\BaseController;
use Core\View;
use enums\ClothingSize;
use enums\ProductStatus;
use Middlewares\AuthMiddleware;
use Models\AccountModel;
use Models\CategoryModel;
use Models\ProductModel;
use Models\ProductVariantModel;
use Models\TypeProductModel;
use Schemas\Product;
use Schemas\ProductVariant;
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
            $id = $this->getQuery('id');

            $products = $this->productModel->getById($id);
            $productVariants = $this->productVariantModel->getAllProductionVariantByIdProduct($id);            
            $categories = $this->categoryModel->getCategories(1,10);
            $types = $this->typeProductModel->getTypeProducts();
            // print_r($products);
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
                if($_POST["price"] == "") die("false + price + Please enter the price of product!");
                if($_POST["material"] == "") die("false + material + Please enter the material of product!");
                if($_POST["made_by"]== "") die("false + made_by + Please fill up made by!");

                $product = new Product();
                $product->name = $_POST["name"];
                $product->material = $_POST["material"];
                $product->madeBy = $_POST["made_by"];
                $product->price = (int)$_POST["price"];
                $product->description = $_POST["description"];
                $product->status = ProductStatus::from($_POST['status']);
                $product->typeProduct = new TypeProduct();
                $product->typeProduct->id = $_POST["type"];

                $this->productModel->addProduct($product);
                $product = $this->productModel->getTopNewProduct(1)[0];
                print_r($product);

                $productVariants = [];
                $productVariantsSended = json_decode($_POST["productVariants"]);
                foreach ($productVariantsSended as $value) {
                    $productVariant = new ProductVariant();
                    $productVariant->product = $product;
                    $productVariant->color = $value->color;
                    $productVariant->size = ClothingSize::tryFrom($value->size);
                    $productVariant->quantity = $value->quantity;
                    $productVariant->quantityPurchased = $value->quantityPurchased;
                    $productVariant->urlImage = $value->urlImage;
                    $productVariants[] = $productVariant;
                }

                foreach ($productVariants as  $value) {
                    $this->productVariantModel->addProductVariant($value);  
                }

                $i = 0;
                while (isset($_FILES["file".$i])) {
                    $file_image = $_FILES["file$i"]['tmp_name'];
                    $dir_saved = $_SERVER["DOCUMENT_ROOT"]."/ban-quan-ao/Images/".$_FILES["file$i"]['name'];
                    move_uploaded_file($file_image,$dir_saved);
                    $i++;
                }
            }  
        }

        public function Update(){
            $mode = $_POST["mode"];

            if ($mode == "Product") {
                if($_POST["name"] == "") die("false + name + Please enter the name of product!");
                if($_POST["price"] == "") die("false + price + Please enter the price of product!");
                if($_POST["material"] == "") die("false + material + Please enter the material of product!");
                if($_POST["made_by"]== "") die("false + made_by + Please fill up made by!");

                $product = new Product();
                $product->id = (int)$_POST["id"];
                $product->name = $_POST["name"];
                $product->material = $_POST["material"];
                $product->madeBy = $_POST["made_by"];
                $product->price = (int)$_POST["price"];
                $product->description = $_POST["description"];
                $product->status = ProductStatus::from($_POST['status']);
                $product->typeProduct = new TypeProduct();
                $product->typeProduct->id = $_POST["type"];

                $this->productModel->updateById($product);

                $productVariants = [];
                $productVariantsSended = json_decode($_POST["productVariants"]);
                foreach ($productVariantsSended as $value) {
                    $productVariant = new ProductVariant();
                    $productVariant->product = $product;
                    $productVariant->color = $value->color;
                    $productVariant->size = ClothingSize::tryFrom($value->size);
                    $productVariant->quantity = (int)$value->quantity;
                    $productVariant->quantityPurchased =(int) $value->quantityPurchased;
                    $productVariant->urlImage = $value->urlImage;
                    $productVariants[] = $productVariant;
                }

                $this->productVariantModel->deleteByIdProduct($product->id);
                foreach ($productVariants as  $value) {
                    $this->productVariantModel->addProductVariant($value);  
                }

                $i = 0;
                while (isset($_FILES["file".$i])) {
                    $file_image = $_FILES["file$i"]['tmp_name'];
                    $dir_saved = $_SERVER["DOCUMENT_ROOT"]."/ban-quan-ao/Images/".$_FILES["file$i"]['name'];
                    move_uploaded_file($file_image,$dir_saved);
                    $i++;
                }
            }
        }
    }
    
?>