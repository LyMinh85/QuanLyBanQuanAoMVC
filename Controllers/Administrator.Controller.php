<?php
namespace Controllers;
use Core\BaseController;
// use Core\Response;
use Core\View;
use enums\ClothingSize;
use enums\ProductStatus;
use Middlewares\AuthMiddleware;
use Models\AccountModel;
use Models\CategoryModel;
use Models\InvoiceModel;
use Models\ProductModel;
use Models\ProductVariantModel;
use Models\RoleModel;
use Models\GroupRoles;
use Models\TypeProductModel;
use Schemas\Account;
use Schemas\Group_roles;
use Models\OrderModel;
use Schemas\Invoice;
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
        private AccountModel $accountModel;
        private OrderModel $orderModel;
        private InvoiceModel $invoiceModel;
        private GroupRoles $groleModel;
        public function register(): void
        {
            new AuthMiddleware();
            $this->productModel = new ProductModel();
            $this->productVariantModel = new ProductVariantModel();
            $this->categoryModel = new CategoryModel();
            $this->typeProductModel = new TypeProductModel();
            $this->roleModel = new RoleModel();
            $this->accountModel = new AccountModel();
            $this->orderModel = new OrderModel();
            $this->invoiceModel = new InvoiceModel();
            $this->groleModel = new GroupRoles();
        }

        public function AdminPage(): void
        {
            session_start();
            print_r($_SESSION["user"]["id_group_role"]);
            $action = $this->getQuery('action');
            if ($action == null) {
                $action = "home";
            }
            $rolesInGroup = $this->groleModel->getRoleInGroup($_SESSION["user"]["id_group_role"]);
            print_r($rolesInGroup);
            $roles = [];
            foreach ($rolesInGroup as $value) {
                $roles[] = $this->roleModel->getById($value);
            }
            View::render("administrator",[
                "roles"=>$roles
            ]);
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





        public function ManageInvoicePage():void{
            $invoices = $this->invoiceModel->getInvoices(1,10);
            View::renderWithoutLayout("manage-in-admin/manage-invoice",[
                "invoices"=>$invoices
            ]);
        }

        public function InvoicePage():void {
            $idInvoice = $this->getQuery('id');
            $invoice = $this->invoiceModel->getById($idInvoice);
            $account = $this->accountModel->getById($invoice->account->id_account);
            $product = $this->productModel->getById($invoice->product->id);
            $productVariant = $this->productVariantModel->getAllProductionVariantByIdProduct($product->getId());

            View::renderWithoutLayout("manage-in-admin/invoice-page",[
                "invoice"=>$invoice,
                "account"=>$account,
                "product"=>$product,
                "productVariant"=>$productVariant
            ]);
        }

        public function RolePage():void {
            // print_r($id);
            $id = $this->getQuery('id');
            $role = $this->roleModel->getById($id);
            View::renderWithoutLayout("manage-in-admin/role-pages",[
                "roles"=>$role,
            ]);
        }
        public function CategoryPage():void {
            // print_r($id);
            $id = $this->getQuery('id');
            // print_r($id);
            $categories = $this->categoryModel->getById($id);
            // print_r($categories);
            View::renderWithoutLayout("manage-in-admin/category-page",[
                "categories"=>$categories
            ]);
        }
        public function TypePage():void {
            // print_r($id);
            $id = $this->getQuery('id');
            // print_r($id);
            $type = $this->typeProductModel->getById($id);
            $categories = $this->categoryModel->getCategories(1,10);
            View::renderWithoutLayout("manage-in-admin/type-page",[
                "type"=>$type,
                "categories"=>$categories
            ]);
        }
        public function GrouprolePage():void {
            $id = $this->getQuery('id');
            $groles = $this->groleModel->getById($id);
            $roles = $this->roleModel->getRoles();
            $rolesInGroup = $this->groleModel->getRoleInGroup($id);
            View::renderWithoutLayout("manage-in-admin/grouprole-page",[
                "groles"=>$groles,
                "roles"=>$roles,
                "rolesInGroup"=>$rolesInGroup
            ]);
        }

        public function AccountPage():void {
            // print_r($id);
            $id = $this->getQuery('id');
            $accounts = $this->accountModel->getById($id);
            $groupRoles = $this->groleModel->getGroupRoles(1,10);

            View::renderWithoutLayout("manage-in-admin/account-page",[
                "accounts"=>$accounts,
                "groupRoles"=>$groupRoles
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
            // print_r($id);

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

                $productVariants = [];
                $productVariantsSended = json_decode($_POST["productVariants"]);
                print_r($productVariantsSended);
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
                print_r($productVariants);

                foreach ($productVariants as  $value) {
                    $this->productVariantModel->addProductVariant($value);  
                }

                $idCus = $_POST["idCus"];
                $sumQuantity = 0;
                $totalPrice = 0;
                foreach ($productVariantsSended as $value) {
                    $sumQuantity += (int)$value->quantity;
                    $totalPrice += (int)$value->quantity * $product->price;
                }

                $invoice = new Invoice();
                $invoice->account = new Account();
                $invoice->account->id_account = $idCus;
                $invoice->product = new Product();
                $invoice->product->id = $product->id;
                $invoice->quantity = $sumQuantity;
                $invoice->sumPrice = $totalPrice;
                date_default_timezone_set("Asia/Bangkok");
                date_create(date("d-m-Y"));
                $invoice->createDate = date_create(date("d-m-Y"));

                $this->invoiceModel->addInvoice($invoice);

                $i = 0;
                while (isset($_FILES["file".$i])) {
                    $file_image = $_FILES["file$i"]['tmp_name'];
                    $dir_saved = $_SERVER["DOCUMENT_ROOT"]."/ban-quan-ao/Images/".$_FILES["file$i"]['name'];
                    move_uploaded_file($file_image,$dir_saved);
                    $i++;
                }
            }  

            if($mode == "Role"){
                $name = $_POST["name"];
                $this->roleModel->addRoles($name);
            }

            if($mode == "GroupRole"){
                $name = $_POST["name"];
                $arrRole = $_POST["arr"];
                $arrRole = explode(",",$arrRole);
                // print_r($arrRole);
                $this->groleModel->addGroupRoles($name,$arrRole);
            }

            if($mode == "Account"){
                $username = $_POST['username'];
                $password = $_POST['password'];
                $name = $_POST['name'];
                $gender = $_POST['gender'];
                $input_birthday = $_POST['birthday'];
                $birthday = \DateTime::createFromFormat('Y-m-d',$input_birthday);
                $phone = $_POST['phone'];
                $address = $_POST['address'];
                $email = $_POST['email'];
                $groupRole = $_POST['groupRole'];
                $idGroup = explode("-",$groupRole)[0];

                if ($this->accountModel->addAccountFromAdmin($username, $password,$name, $gender,$birthday, $phone, $address,$email,$idGroup)){
                    header("Location: http://localhost/ban-quan-ao/administrator/");
                    die();
                } else{
                    View::render('sign-up');
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
                print_r($product);

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

            if($mode == "GroupRole"){
                $name = $_POST["name"];
                $id = $_POST["id"];
                $arr = $_POST["arr"];
                $arr = explode(",",$arr);
                
                $groupRole = new Group_roles($id,$name);
                $this->groleModel->updateGroupRoles($groupRole,$arr);
            }

            if($mode == "Account"){
                $username = $_POST['username'];
                $password = $_POST['password'];
                $name = $_POST['name'];
                $gender = $_POST['gender'];
                $phone = $_POST['phone'];
                $address = $_POST['address'];
                $email = $_POST['email'];
                $groupRole = $_POST['groupRole'];
                $idGroup = explode("-",$groupRole)[0];
                $idAccount = $_POST["id"];

                $account = new Account();
                $account->id_account = $idAccount;
                $account->username = $username;
                $account->password = $password;
                $account->name = $name;
                $account->gender = $gender;
                $account->phone = $phone;
                $account->address = $address;
                $account->email = $email;
                $account->id_group_roles = (int)$idGroup;
                print_r($account);


                if ($this->accountModel->updateAccountFromAdmin($account)){
                    header("Location: http://localhost/ban-quan-ao/administrator/");
                    die();
                } else{
                    View::render('sign-up');
                }
            }
        }
    }
    
?>