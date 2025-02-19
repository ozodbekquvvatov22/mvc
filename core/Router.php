<?php
class Router
{
    private $routes = [];
    public function get($url, $action)
    {
        $this->routes['GET'][$url] = $action;
    }
    public function post($url, $action)
    {
        $this->routes['POST'][$url] = $action;
    }
    public function dispatch()
    {

        $protectedRoutes = ['/post/index', '/post/create', '/post/edit', '/post/delete', '/post/show','/post/update','/post/show','/auth/logout'];

        $requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); 
        
        if (in_array($requestPath, $protectedRoutes) && !isset($_SESSION['user_id'])) {
            header("Location: /auth/login");
            exit();
        }
        $url = strtok($_SERVER["REQUEST_URI"], '?');
        $method = $_SERVER['REQUEST_METHOD'];
        if (!isset($this->routes[$method][$url])) {
            echo "404 - Page Not Found";
            return;
        }
        $action = $this->routes[$method][$url];
        if (is_callable($action)) {
            call_user_func($action);
            return;
        }
        if (!is_string($action) || !str_contains($action, '@')) {
            die("Xatolik: Marshrut noto‘g‘ri formatda berilgan!");
        }
        list($controller, $method) = explode('@', $action);
        require_once "../app/Controllers/$controller.php";

        if (!class_exists($controller)) {
            die("Xatolik: `$controller` classi topilmadi!");
        }
        $controller = new $controller;
        if (!method_exists($controller, $method)) {
            die("Xatolik: `$method` metodi `$controller` ichida topilmadi!");
        }

        $controller->$method();
    }
}
