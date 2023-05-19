<?php

class Config
{
    public const DB_HOSTNAME = 'localhost';
    public const DB_USERNAME = 'root';
    public const DB_PASSWORD = '85659712';
    public const DB_DATABASE = 'quan_ly_ban_quan_ao';
    public const SHOW_ERRORS = true;
    public const PROJECT_NAME = 'ban-quan-ao';
    public static function getRootDir(): string {
        return '/' . self::PROJECT_NAME;
    }

    public static function getUrl(string $url): string {
        return self::getRootDir() . $url;
    }

    public static function getUrlWithQuery(string $url, array $queries): string {
        foreach ($queries as $query => $value) {
            $url .= "&$query=$value";
        }
        return self::getUrl($url);
    }
}