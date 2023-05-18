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


