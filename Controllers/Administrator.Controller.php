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
use Models\RoleModel;
use Models\GroupRoles;
use Models\TypeProductModel;
use Models\OrderModel;
use Schemas\Product;
use Schemas\ProductVariant;
use Schemas\Role;
use Schemas\TypeProduct;
    class AdministratorController extends BaseController
    {
        private ProductModel $productModel;
        private ProductVariantModel $productVariantModel;
        private CategoryModel $categoryModel;
        private TypeProductModel $typeProductModel;
        private RoleModel $roleModel;
        private GroupRoles $groleModel;
        private AccountModel $accountModel;
        private OrderModel $orderModel;
        public function register(): void
        {
            new AuthMiddleware();
            $this->productModel = new ProductModel();
            $this->productVariantModel = new ProductVariantModel();
            $this->categoryModel = new CategoryModel();
            $this->typeProductModel = new TypeProductModel();
            $this->roleModel = new RoleModel();
            $this->groleModel = new GroupRoles();
            $this->accountModel = new AccountModel();
            $this->orderModel = new OrderModel();
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


        public function ManageRolesPage():void {
            $roles = $this->roleModel->getRoles();
            // print_r($roles);
            View::renderWithoutLayout("manage-in-admin/manage-roles",[
                "roles"=>$roles
            ]);
        }

        public function ManageCategoryPage():void{
            $categories = $this->categoryModel->getCategories(1,10);

            View::renderWithoutLayout("manage-in-admin/manage-category",[
                "categories"=>$categories
            ]);
        }
        public function ManageTypePage():void{
            $types = $this->typeProductModel->getTypeProducts();

            View::renderWithoutLayout("manage-in-admin/manage-type",[
                "types"=>$types
            ]);
        }
        
        public function ManageGrouprolePage():void {
            $groles = $this->groleModel->getGroupRoles(1,10);
            // print_r($roles);
            View::renderWithoutLayout("manage-in-admin/manage-grouprole",[
                "groles"=>$groles
            ]);
        }
        public function ManageAccountPage():void {
            $accounts = $this->accountModel->getAccounts(1,10);
          
            View::renderWithoutLayout("manage-in-admin/manage-account",[
                "accounts"=>$accounts
            ]);
        }
        public function ManageOrderPage():void {
            $orders = $this->orderModel->getOrders(1,10);
          
            View::renderWithoutLayout("manage-in-admin/manage-order",[
                "orders"=>$orders
            ]);
        }





        public function RolePage():void {
            // print_r($id);
            $id = $this->getQuery('id');
            print_r($id);
            $role = $this->roleModel->getById($id);
            View::renderWithoutLayout("manage-in-admin/role-pages",[
                "roles"=>$role,
            ]);
        }
        public function CategoryPage():void {
            // print_r($id);
            $id = $this->getQuery('id');
            print_r($id);
            $categories = $this->categoryModel->getById($id);
            print_r($categories);
            View::renderWithoutLayout("manage-in-admin/category-page",[
                "categories"=>$categories
            ]);
        }
        public function TypePage():void {
            // print_r($id);
            $id = $this->getQuery('id');
            print_r($id);
            $type = $this->typeProductModel->getById($id);
            $categories = $this->categoryModel->getCategories(1,10);
            View::renderWithoutLayout("manage-in-admin/type-page",[
                "type"=>$type,
                "categories"=>$categories
            ]);
        }
        public function GrouprolePage():void {
            // print_r($id);
            $id = $this->getQuery('id');
            print_r($id);
            $groles = $this->groleModel->getById($id);
            View::renderWithoutLayout("manage-in-admin/grouprole-page",[
                "groles"=>$groles,
            ]);
        }

        public function AccountPage():void {
            // print_r($id);
            $id = $this->getQuery('id');
            print_r($id);
            $accounts = $this->accountModel->getById($id);
            View::renderWithoutLayout("manage-in-admin/account-page",[
                "accounts"=>$accounts,
            ]);
        }
        public function OrderPage():void {
            // print_r($id);
            $id = $this->getQuery('id');
            print_r($id);
            $orders = $this->orderModel->getById($id);
            View::renderWithoutLayout("manage-in-admin/order-page",[
                "orders"=>$orders,
            ]);
        }
        public function ProductPage():void {
            // print_r($id);
            $id = $this->getQuery('id');
            print_r($id);

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