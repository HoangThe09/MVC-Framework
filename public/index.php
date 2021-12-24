<?php
session_start();
use libs\Router;
// autoload
require_once dirname(__DIR__).'/vendor/autoload.php';
// spl_autoload_register(function ($class){
//     $root = dirname(__DIR__);
//     $file = $root . '/' . str_replace('\\', '/', $class) . '.php';
//     if(file_exists($file)){
//         require_once $file;
//     }
// });
// Get url
$url = $_SERVER['PATH_INFO'] ?? '';
$url = rtrim($url, '/') ?: '/';
// Routing
$router = new Router($url);