<?php

class Router
{
    private $routes = [];
    public function get($route, $action)
    {
        $this->routes['GET'][$route] = ['params' => [], 'actions' => $action];
    }
    public function post($route, $action)
    {
        $this->routes['POST'][$route] = ['params' => [], 'actions' => $action];
    }
    public function resolve()
    {
        $requestUri = strtok($_SERVER['REQUEST_URI'], '?');
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if (isset($this->routes[$requestMethod][$requestUri])) {
            $getRoutes = $this->routes[$requestMethod][$requestUri];
            [$controller, $method] = $getRoutes['actions'];
            $controllerInstance = new $controller();
            if (is_callable([$controllerInstance, $method])) {
                call_user_func_array([$controllerInstance, $method], $getRoutes['params']);
                exit;
            } else {
                http_response_code(500);
                echo "Function: {$method} Not Found";
                exit;
            }
        }
        http_response_code(404);
        echo "404 Not Found";
    }
}


$router = new Router();
