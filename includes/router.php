<?php
class Router
{
    private static $instance = null;
    private $routes = [];

    // Private constructor to prevent direct object creation
    private function __construct() {}

    // Private clone method to prevent cloning of the instance
    private function __clone() {}

    // Method to get the singleton instance
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function addRoute($route, $function, $method = 'GET')
    {
        $normalizedRoute = trim($route, '/');
        $method = strtoupper($method);
        $this->routes[$method][$normalizedRoute] = $function;
    }

    public function dispatch()
    {
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
        $url = trim($url, '/');
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET'; 

        if (isset($this->routes[$method][$url])) {
            call_user_func($this->routes[$method][$url]);
        } else {
            http_response_code(404);
            echo "Page not found";
        }
    }
}
