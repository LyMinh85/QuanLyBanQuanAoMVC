<?php

class Helper
{
    public static function println(string $title, $var)
    {
        print_r($title);
        print_r($var);
        print_r("</br>");
    }
}
