<?php

namespace Core;

use Config;
use Exception;
use Helper;

class DB
{
    private static \mysqli|null $conn = null;

    public static function getDB() : \mysqli
    {
        if (DB::$conn === null) {
            DB::$conn = DB::connect();
        }

        return DB::$conn;
    }

    /**
     * @throws Exception
     */
    private static function connect(): \mysqli
    {
        $conn = new \mysqli(
            Config::DB_HOSTNAME,
            Config::DB_USERNAME,
            Config::DB_PASSWORD,
            Config::DB_DATABASE
        );
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . DB::$conn->connect_error);
        }

        return $conn;
    }

    public static function close(): void
    {
        if (DB::$conn) {
            DB::$conn->close();
            DB::$conn = null;
        }
    }
}
