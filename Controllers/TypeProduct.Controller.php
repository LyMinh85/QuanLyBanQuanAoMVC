<?php

namespace Controllers;

use Core\Response;
use Models\TypeProductModel;

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
}