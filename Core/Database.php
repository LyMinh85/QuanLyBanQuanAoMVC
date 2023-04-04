<?php

namespace Core;

use Config;
use Helper;

class DB
{
    private static $conn = null;
    public static function getDB()
    {
        try {
            if (DB::$conn == null || DB::$conn->ping()) {
                DB::connect();
            }
        } catch (\Error $e) {
            DB::connect();
        }

        return DB::$conn;
    }

    private static function connect()
    {
        if (DB::$conn = new \mysqli(
            Config::DB_HOSTNAME,
            Config::DB_USERNAME,
            Config::DB_PASSWORD,
            Config::DB_DATABASE
        )) {
            if (DB::$conn->connect_error) {
                die("Connection failed: " . DB::$conn->connect_error);
            }
        } else {
            throw new \Exception("Can't connect to database.");
        }
    }

    public static function close()
    {
        return DB::$conn->close();
    }
}
