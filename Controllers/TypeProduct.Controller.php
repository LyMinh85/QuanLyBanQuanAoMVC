<?php

namespace Controllers;

use Core\Response;
use Core\Validate;
use enums\Gender;
use Models\TypeProductModel;
use Schemas\Category;
use Schemas\TypeProduct;

class TypeProductController extends \Core\BaseController
{
    private TypeProductModel $typeProductModel;
    public function register(): void
    {
        $this->typeProductModel = new TypeProductModel();
    }

    public function getTypeProducts(): void {
        $typeProducts = $this->typeProductModel->getTypeProducts();
        Response::sendJson($typeProducts);
    }

    public function addTypeProduct(): void {
        $bodyData = Validate::getBodyData(['name', 'idCategory', 'gender']);
        $name = $bodyData['name'];
        $idCategory = $bodyData['idCategory'];
        $gender = Gender::tryFrom($bodyData['gender']);

        if ($gender === null) {
            Response::sendJson("Invalid gender field ");
        }

        $typeProduct = new TypeProduct();
        $typeProduct->name = $name;
        $typeProduct->category = new Category();
        $typeProduct->category->id = $idCategory;
        $typeProduct->gender = $gender;
        if ($this->typeProductModel->addOne($typeProduct)) {
            Response::sendJson("Added new typeProduct successfully");
        } else {
            Response::sendJson("Failed to add");
        }
    }

    public function getById(int $id): void {
        $typeProduct = $this->typeProductModel->getById($id);
        if (is_null($typeProduct)) {
            Response::sendJson("Not found");
        } else {
            Response::sendJson($typeProduct);
        }
    }

    public function deleteById(int $id): void {
        if ($this->typeProductModel->deleteById($id)) {
            Response::sendJson("Deleted typeProduct successfully");
        } else {
            Response::sendJson("Failed to delete");
        }
    }

    public function updateById(int $id): void {
        $bodyDate = Validate::getBodyData(['name', 'idCategory', 'gender']);
        $name = $bodyDate['name'];
        $idCategory = (int) $bodyDate['idCategory'];
        $gender = $bodyDate['gender'];

        if (Gender::tryFrom($gender) == null) {
            Response::sendJson("Invalid gender field ");
        }

        $typeProduct = $this->typeProductModel->getById($id);
        $typeProduct->setName($name);
        $typeProduct->setIdCategory($idCategory);
        $typeProduct->setGender($gender);

        if ($this->typeProductModel->updateById($typeProduct)) {
            Response::sendJson($typeProduct);
        } else {
            Response::sendJson("Failed to edit");
        }
    }
}