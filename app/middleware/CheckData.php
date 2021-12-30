<?php
namespace app\middleware;

class CheckData extends Middleware
{
    public function action ($params)
    {
        $message = null;
        if(empty($params['title'])){
            $message .= "Title not empty \n";
        }
        if(empty($params['description'])){
            $message .= "Description not empty \n";
        }
        if(empty($params['expiration'])){
            $message .= "Expiration not empty \n";
        }
        
        if($message != null){
            throw new \libs\HandleException($message, 400);
        }
    }
}