<?php

namespace Core;

use Config;
use Helper;

class DB
{
    private static $conn = null;
    public static function getDB()
    {
        if (DB::$conn === null || !DB::$conn->ping()) {
            DB::$conn = DB::connect();
        }

        return DB::$conn;
    }

    private static function connect()
    {
        $conn = new \mysqli(
            Config::DB_HOSTNAME,
            Config::DB_USERNAME,
            Config::DB_PASSWORD,
            Config::DB_DATABASE
        );
        if ($conn->connect_error) {
            throw new \Exception("Connection failed: " . DB::$conn->connect_error);
        }

        return $conn;
    }

    public static function close()
    {
        if (DB::$conn) {
            DB::$conn->close();
            DB::$conn = null;
        }
    }
}
