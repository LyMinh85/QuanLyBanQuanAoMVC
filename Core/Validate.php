<?php

namespace Core;

class Validate {
    public static function getBodyData(array $keys): array {
        $invalidFields = [];
        $bodyData = [];
        foreach ($keys as $key) {
            if (!isset($_POST[$key])) {
                $invalidFields[] = "Missing $key field";
            } else {
                $bodyData[$key] = $_POST[$key];
            }
        }
        if (count($invalidFields) !== 0) {
            Response::sendJson($invalidFields, 400);
        }
        return $bodyData;
    }
}