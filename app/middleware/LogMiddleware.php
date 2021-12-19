<?php
namespace app\middleware;

class LogMiddleware
{
    protected $next = true;
    public function action ($params)
    {
       header("location: /post/index");
    }
}