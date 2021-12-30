<?php

namespace libs;

class Router
{
    protected static $routes = [];
    protected static $params = [];
    /**
     * Add a route to the routing table
     * 
     * @param string $method the method request
     * @param string $route the route URL
     * @param array $params Parameters (controller, action, etc.)
     * 
     */
    public function __construct($url)
    {
        require_once dirname(__DIR__) . '/routes/web.php';
        Router::dispatch($url);
    }
    public static function addRoute($method, $uri, $params, $middleware = [])
    {
        $uri = preg_replace('/\//', '\\/', $uri);
        $uri = preg_replace('/\{([a-z]+)\}/', '(?P<\1>\w+)', $uri);
        $uri = "/^$uri$/i";
        static::$routes[$uri][$method] = [
            'controller' => $params[0],
            'action' => $params[1],
            'middleware' => $middleware,
        ];
    }
    /**
     * Add a route to the routing with GET method
     * 
     * @param string $route the route URL
     * @param array $params Parameters (controller, action, etc.)
     * 
     */
    public static function get($uri, $params, $middleware = [])
    {
        static::addRoute('GET', $uri, $params, $middleware);
    }
    /**
     * Add a route to the routing with POST method
     * 
     * @param string $route the route URL
     * @param array $params Parameters (controller, action, etc.)
     * 
     */
    public static function post($uri, $params, $middleware = [])
    {
        static::addRoute('POST', $uri, $params, $middleware);
    }

    public static function put($uri, $params, $middleware = [])
    {
        static::addRoute('PUT', $uri, $params, $middleware);
    }

    public static function patch($uri, $params, $middleware = [])
    {
        static::addRoute('PATCH', $uri, $params, $middleware);
    }

    public static function delete($uri, $params, $middleware = [])
    {
        static::addRoute('DELETE', $uri, $params, $middleware);
    }

    public static function group($option, $callback)
    {
        $routes = static::$routes;
        static::$routes = [];
        if (is_callable($callback)) {
            $callback();
        }
        $newRoutes = [];
        foreach (static::$routes as $pattern => $params) {
            if (isset($option['middleware'])) {
                foreach ($params as &$param) {
                    $param['middleware'] = array_unique(array_merge($param['middleware'], $option['middleware']));
                }
            }
            if (isset($option['prefix'])) {
                $prefix = $option['prefix'];
                $pattern = str_replace('^', "^\/$prefix", $pattern);
            }
            $newRoutes[$pattern] = $params;
        }
        static::$routes = array_merge($routes, $newRoutes);
    }

    /**
     * get all the routes from the routing table
     */
    public static function getRoutes()
    {
        return static::$routes;
    }

    public static function match($url)
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        foreach (static::$routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                if (isset($params[$requestMethod])) {
                    foreach ($matches as $key => $value) {
                        if (is_string($key)) {
                            $params[$requestMethod][$key] = $value;
                        }
                    }
                    // Get data from Put, Patch method
                    $input = file_get_contents("php://input");
                    if($input){
                        $input = explode('&', $input);
                        foreach ($input as $value) {
                            $pos =  strpos($value, '=');
                            $key = substr($value, 0, $pos);
                            $value = substr($value, $pos + 1);
                            if (!isset($params[$key])) {
                                $params[$requestMethod][$key] = $value;
                            }
                        }
                    }
                    static::$params = $params[$requestMethod];
                    return true;
                } else {
                    throw new HandleException("The $requestMethod method is not supported for this route", 405);
                }
            }
        }
        return false;
    }

    /**
     * get the currently parameters
     * @return array
     */
    public static function getParams()
    {
        return static::$params;
    }

    public static function dispatch($url)
    {
        if (static::match($url)) {
            $middlewareArr = static::$params['middleware'] ?? null;
            if ($middlewareArr) {
                foreach ($middlewareArr as $middleware) {
                    $middlewareObj = new $middleware;
                    $middlewareObj->action(static::$params);
                }
            }
            $controller = static::$params['controller'];
            if (class_exists($controller)) {
                $controller_obj = new $controller(static::$params);
                $action = static::$params['action'];
                $action = static::convertToCamelCase($action);
                if (is_callable([$controller_obj, $action])) {
                    $controller_obj->$action();
                } else {
                    throw new HandleException("Method $action class $controller not found", 404);
                }
            } else {
                throw new HandleException("Controller class $controller not found", 404);
            }
        } else {
            throw new HandleException("No matched route", 404);
        }
    }

    public static function convertToCamelCase($string)
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('-', ' ', $string))));
    }
}
