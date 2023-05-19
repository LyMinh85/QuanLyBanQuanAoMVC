<?php
namespace Controllers;

use Core\BaseController;
use Core\Response;
use Core\Validate;
use Core\View;
use Models\CategoryModel;
use Models\ProductModel;

class HomeController extends BaseController
{
    private ProductModel $productModel;
    private CategoryModel $categoryModel;
    public function register() {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index(): void
    {
        session_start();

        $page = (int) $this->getQuery('page');
        $resultsPerPage = (int) $this->getQuery('resultsPerPage');
        $name = $this->getQuery('name');
        $type = (int) $this->getQuery('type'); // typeProductName
        $category = (int) $this->getQuery('category');
        $priceRange = $this->getQuery('priceRange');

        // Default
        $page = $page == 0 ? 1 : $page;
        $resultsPerPage = $resultsPerPage == 0 ? 8 : $resultsPerPage;
        $priceMin = 0;
        $priceMax = null;

        // Validate price range
        // priceRange = 'min-max' => price >= min and price <= max
        // Example: priceRange = '100-10000' => price >= 100 and price <= max
        if ($priceRange != null) {
            $priceRangeArray = explode("-", $priceRange);

            if (isset($priceRangeArray[0])) {
                $priceMin = $priceRangeArray[0];
            }

            if (isset($priceRangeArray[1])) {
                $priceMax = $priceRangeArray[1];
            }

            Response::logger("Min", $priceMin);
            Response::logger("Max", $priceMax);
        }

        if ($name != null || $type != 0 || $category != 0 || $priceRange != null) {
            $numberOfPage = $this->productModel->getNumberOfPageByConditions(
                $resultsPerPage, $name, $type, $category, $priceMin, $priceMax
            );
            $products = $this->productModel->getProductsByConditions(
                $page, $resultsPerPage, $name, $type, $category, $priceMin, $priceMax
            );
        } else {
            $numberOfPage = $this->productModel->getNumberOfPage($resultsPerPage);
            $products = $this->productModel->getProducts($page, $resultsPerPage);
        }

        $categories = $this->categoryModel->getCategories($page, $resultsPerPage);

        $user = null;
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
        }

        View::render("home", [
            'pagination' => [
                'resultPerPage' => $resultsPerPage,
                'currentPage' => $page,
                'numberOfPage' => $numberOfPage
            ],
            'queries' => $this->queries,
            'products' => $products,
            'categories' => $categories,
            'user' => $user
        ]);
    }


}