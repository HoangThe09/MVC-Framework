<?php
namespace app\middleware;

abstract class  Middleware
{
    abstract public function action ($params);
}