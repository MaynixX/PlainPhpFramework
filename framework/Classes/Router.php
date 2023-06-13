<?php

namespace Framework\Classes;

use App\Controllers\Controller;

class Router{
    private static $routes = [
        "GET" => [],
        "POST" => []
    ];

    public static function getRoutes() : array{
        return self::$routes;
    }

    public static function getRoute(string $path){
        $path = self::getTrimedPath($path);
        $method = $_SERVER['REQUEST_METHOD'];
        if(!array_key_exists($path, self::$routes[$method])) abort("Не существует роута <b>{$path}</b> с методом {$method}");
        $route = self::$routes[$method][$path];
        return $route["controller"]->{$route['method']}();
    }

    public static function get(string $path, Controller $controller, string $method_name) : void{
        $path = self::getTrimedPath($path);
        $controller_and_method = self::getRouteFrom($controller, $method_name);
        self::$routes['GET'][$path] = $controller_and_method;
    }
    public static function post(string $path, Controller $controller, string $method_name) : void{
        $path = self::getTrimedPath($path);
        $controller_and_method = self::getRouteFrom($controller, $method_name);
        self::$routes['POST'][$path] = $controller_and_method;
    }
    private static function getRouteFrom(Controller $controller, string $method_name) : array{
        $method_name = trim($method_name);
        if(!method_exists($controller, $method_name)) abort("Метода '{$method_name}' не существует");
        return ["controller" => $controller, "method" => $method_name];
    }
    private static function getTrimedPath(string $path) : string{
        return trim(trim($path), "/");
    }
}