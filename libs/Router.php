<?php

namespace libs;
use app\middleware\LogMiddleware;
class Router
{
    protected static $routes = [];
    protected static $params = [];
    protected static $method = [];

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
        require_once dirname(__DIR__).'/routes/web.php';
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
        try {
            foreach (static::$routes as $route => $params) {
                if (preg_match($route, $url, $matches) && isset($params[$requestMethod])) {
                    foreach ($matches as $key => $value) {
                        if (is_string($key)) {
                            $params[$requestMethod][$key] = $value;
                        }
                    }
                    static::$params = $params[$requestMethod];
                    return true;
                }else if(!isset($params[$requestMethod])){
                    throw new HandleException("The $requestMethod method is not supported for this route");
                }
            }
            return false;
        } catch (HandleException $e) {
            echo $e->getMessage();
            die;
        }
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
        try {
            if (static::match($url)) {
                $middlewareArr = static::$params['middleware'] ?? null;
                if($middlewareArr){
                    foreach($middlewareArr as $middleware){
                        $middleware = static::convertToStudlyCaps($middleware);
                        $middlewareObj = new $middleware;
                        $middlewareObj->action(static::$params);
                    }
                }
                $controller = static::$params['controller'];
                $namespace = static::getNamespace();
                $controller = $namespace . static::convertToStudlyCaps($controller);
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
        } catch (HandleException $e) {
            echo $e->getMessage();
        }
    }

    public static function convertToStudlyCaps($string)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    public static function convertToCamelCase($string)
    {
        return lcfirst(static::convertToStudlyCaps($string));
    }

    public static function getNamespace()
    {
        $namespace = "App\Controllers\\";
        if (array_key_exists('namespace', static::$params)) {
            $namespace .= ucfirst(static::$params['namespace']) . '\\';
        }
        return $namespace;
    }
}
