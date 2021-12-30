<?php
namespace app\middleware;

abstract class  Middleware
{
    protected $next = true;

    abstract public function action ($params);
}