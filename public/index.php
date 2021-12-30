<?php
session_start();
use libs\Router;
use libs\HandleException;

// autoload
require_once dirname(__DIR__).'/vendor/autoload.php';

// Get url
$url = $_SERVER['PATH_INFO'] ?? '';
$url = rtrim($url, '/') ?: '/';
// Routing
try {
    $router = new Router($url);
}
catch (HandleException $e){
    $e->exceptionHandler();
}