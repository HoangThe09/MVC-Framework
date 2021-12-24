<?php
namespace app\middleware;

class CheckLogin extends Middleware
{
    protected $next = true;

    public function action ($params)
    {
        if(isset($_SESSION['user'])){
            return $this->next = true;
        }else{
            // exit('chưa đăng nhập');
        }
    }
}