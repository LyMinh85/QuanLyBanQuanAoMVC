<?php

namespace Core;

class Request
{

    /**
     *  Get REQUEST Super Global
     * @var
     */
    public $request;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->request = ($_REQUEST);
    }

    /**
     *  Get $_GET parameter
     */
    public function get(string $key = ''): string
    {
        if ($key != '')
            return isset($_GET[$key]) ? $this->clean($_GET[$key]) : null;

        return  $this->clean($_GET);
    }

    /**
     *  Get $_POST parameter
     */
    public function post(string $key = ''): string
    {
        if ($key != '')
            return isset($_POST[$key]) ? $this->clean($_POST[$key]) : null;

        return  $this->clean($_POST);
    }

    /**
     *  Get value for server super global var
     */
    public function server(string $key = ''): string
    {
        return isset($_SERVER[strtoupper($key)]) ? $this->clean($_SERVER[strtoupper($key)]) : $this->clean($_SERVER);
    }

    /**
     *  Get Method
     *
     * @return string
     */
    public function getMethod()
    {
        return strtoupper($this->server('REQUEST_METHOD'));
    }

    /**
     *  Returns the client IP addresses.
     *
     * @return string
     */
    public function getClientIp()
    {
        return $this->server('REMOTE_ADDR');
    }

    /**
     *  Script Name
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->server('REQUEST_URI');
    }

    public function getQueryString(): string
    {
        $queryString = str_replace('&amp;', '&', $this->server('QUERY_STRING'));
        $pos = strpos($queryString, "&");
        if ($pos !== false) {
            $queryString = substr_replace($queryString, "?", $pos, strlen("&"));
        }
        return $queryString;
    }

    /**
     * Clean Data
     *
     * @param $data
     * @return string
     */
    private function clean($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {

                // Delete key
                unset($data[$key]);

                // Set new clean key
                $data[$this->clean($key)] = $this->clean($value);
            }
        } else {
            $data = htmlspecialchars($data, ENT_COMPAT, 'UTF-8');
        }

        return $data;
    }
}
