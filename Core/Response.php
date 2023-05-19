<?php

namespace Core;

class Response
{
    private static $response = [
        'logger' => [],
    ];
    public static function logger($message, $context = 'Unknow', $type = 'Debug')
    {
        $log = [
            'message' => $message,
            'type' => $type,
            'context' => $context,
        ];
        Response::$response['logger'][] = $log;
    }
    public static function sendJson($data, $statusCode = 200)
    {
        if ($statusCode == 200) {
            Response::$response['content'] = $data;
        } else {
            Response::$response['error'] = $data;
        }
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($statusCode);
        echo json_encode(Response::$response);
        die();
    }

    public static function redirect($url, $statusCode = 303)
    {
        $url = \Config::getUrl($url);
        header('Location: ' . $url, true, $statusCode);
        die();
    }
}
