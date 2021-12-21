<?php
namespace app\middleware;

class LogMiddleware extends Middleware
{
    protected $next = true;

    public function action ($params)
    {
    //    header("location: /post/index");
        $this->next = false;
       return $this->next;
    }
}