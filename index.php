<?php
use Core\App;

// Import App
require_once("Core/App.php");

$app = new App();

// Home page
$app->get('/', "Home@index");

// Product controller
$app->get('products', "Product@getProducts");
$app->post('products', 'Product@addProduct');
$app->delete('products/{id:\d+}', 'Product@deleteProduct');
$app->post('products/{id:\d+}', 'Product@updateProduct');
$app->get('products/{id:\d+}', "Product@getProduct");

// Category controller
$app->get('categories', "Category@getCategories");
$app->post('categories', 'Category@addCategory');
$app->get('categories/{id:\d+}', 'Category@getById');
$app->delete('categories/{id:\d+}', 'Category@deleteById');
$app->post('categories/{id:\d+}', 'Category@updateCategory');

// Account
$app->get('accounts', "Account@getAccounts");
$app->post('accounts', 'Account@addAccount');
$app->get('accounts/{id:\d+}', 'Account@getById');
$app->delete('accounts/{id:\d+}', 'Account@deleteById');
$app->post('accounts/{id:\d+}', 'Account@updateAccount');

//Customer
$app->get('customers', "Customer@getCustomers");
$app->post('customers', 'Customer@addCustomer');
$app->get('customers/{id:\d+}', 'Customer@getById');
$app->delete('customers/{id:\d+}', 'Customer@deleteById');
$app->post('customers/{id:\d+}', 'Customer@updateCustomer');

//Orders
$app->get('orders', "Order@getOrders");
$app->post('orders', 'Order@addOrder');
$app->get('orders/{id:\d+}', 'Order@getById');
$app->delete('orders/{id:\d+}', 'Order@deleteById');
$app->post('orders/{id:\d+}', 'Order@updateOrder');

// TypeProduct controller
$app->get('type-products', "TypeProduct@getTypeProducts");
$app->post('type-products', "TypeProduct@addTypeProduct");
$app->post('type-products/{id:\d+}', "TypeProduct@updateById");
$app->delete('type-products/{id:\d+}', "TypeProduct@deleteById");


// ProductVariant controller
$app->get('products/variants', "ProductVariant@getProductVariants");
$app->post('products/variants', "ProductVariant@addProductVariant");

// Invoice
$app->get('invoices', "Invoice@getInvoices");
$app->post('invoices', "Invoice@addInvoice");


// Login
$app->get("login", 'Home@loginPage');
$app->post('login', 'Home@login');

$app->run();


