<?php

namespace wfm;

class Router
{
    protected static array $routes = [];
    protected static array $route = [];
    public static function add($regexp, $route = [])
    {
        self::$routes[$regexp] = $route;
    }
    public static function getRoutes(): array
    {
        return self::$routes;
    }
    public static function getRoute(): array
    {
        return self::$route;
    }
    public static function dispatch($url)
    {
        if (self::matchRoute($url)) {
            $controller = 'app\controllers\\' .
                self::$route['admin_prefix'] .
                self::$route['controller'] .
                'Controller';
            if (class_exists($controller)) {
                $controllerObject = new $controller(self::$route);
                $action = self::lowerCamelCase(self::$route['action']) . 'Action';
                    if (method_exists($controllerObject, $action)) {
                        $controllerObject->$action();
                    } else {
                        throw new \Exception("Method: <b>{$action}</b> inside <b>{$controller}</b> is not found");
                    }
            } else {
                throw new \Exception("Controller <b>{$controller}</b> is not found", 404);
            }
        } else {
            throw new \Exception("No matches for <b>{$url}</b>",404);
        }
    }
    public static function matchRoute($url): bool
    {
        foreach (self::$routes as $pattern => $route) {
            if (preg_match("#{$pattern}#i", $url, $matches)) {
                foreach ($matches as $k => $v) {
                    if (is_string($k)) {
                        $route[$k] = $v;
                    }
                }
                if (empty($route['action']))
                    $route['action'] = 'index';
                if (!isset($route['admin_prefix']))
                    $route['admin_prefix'] = '';
                else
                    $route['admin_prefix'] .= '\\';
                $route['controller'] = self::upperCamelCase($route['controller']);
                self::$route = $route;
                return true;
            }
        }
        return false;
    }
    protected static function upperCamelCase($name): string
    {
        $name = str_replace('-', ' ', $name);
        $name = ucwords($name);
        $name = str_replace(' ', '', $name);
        return $name;
    }

    protected static function lowerCamelCase($name): string
    {
        return lcfirst(self::upperCamelCase($name));
    }

}











