<?php

namespace Controllers;
use Core\BaseController;
use Core\Response;
use Core\Validate;
use Models\CategoryModel;
use Schemas\Category;

class CategoryController extends BaseController {
    private CategoryModel $categoryModel;
    public function register(): void {
        $this->categoryModel = new CategoryModel();
    }

    public function getCategories(): void {
        $page = $this->getQuery('page');
        $resultsPerPage = $this->getQuery('resultsPerPage');
        $name = $this->getQuery('name');

        $page = is_null($page) ? 1 : $page;
        $resultsPerPage = is_null($resultsPerPage) ? 20 : $resultsPerPage;

        $numberOfPage = $this->categoryModel->getNumberOfPage($resultsPerPage);
        
        $categories = [];
        if (!is_null($name)) {
            $categories = $this->categoryModel->findByName($page, $resultsPerPage, $name);
        } else {
            $categories = $this->categoryModel->getCategories($page, $resultsPerPage);
        }
        Response::sendJson([
            'pagination' => [
                'currentPage' => $page,
                'numberOfPage' => $numberOfPage
            ],
            'categories' => $categories,
        ]);
    }

    public function getById(int $id): void {
        $category = $this->categoryModel->getById($id);
        if (is_null($category)) {
            Response::sendJson("Not found");
        }
        Response::sendJson($category);
    }

    public function deleteById(int $id): void {
        if ($this->categoryModel->deleteById($id)) {
            Response::sendJson("Deleted category successfully");
        } else {
            Response::sendJson("Failed to delete");
        }
    }

    public function addCategory(): void {
        $bodyData = Validate::getBodyData(['name']);
        $name = $bodyData['name'];
        if ($this->categoryModel->addCategory($name)) {
            Response::sendJson("Added new category successfully");
        } else {
            Response::sendJson("Failed to add");
        }
    }

    public function updateCategory(int $id): void {
        $bodyDate = Validate::getBodyData(['name']);
        $name = $bodyDate['name'];
        $category = new Category($id, $name);
        if ($this->categoryModel->updateCategory($category)) {
            Response::sendJson($category);
        } else {
            Response::sendJson("Failed to edit");
        }
    }
}