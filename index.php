<?php
use Core\App;

// Import App
require_once("Core/App.php");

$app = new App();

$app->get('/', "Home@index");

$app->get('products', "Product@getAll");
$app->post('products', 'Product@addProduct');
$app->delete('products/{id:\d+}', 'Product@deleteProduct');
$app->post('products/{id:\d+}', 'Product@updateProduct');
$app->get('products/{id:\d+}', "Product@getProduct");


$app->get('debug', "Debug@index");

$app->run();


