<?php
namespace libs;

class View
{
    public static function render($view, $data = [])
    {
        extract($data);
        $file = "../App/Views/$view.php";
        if(file_exists($file)){
            require $file;
        }else{
            throw new \Exception("<br> View $file not found", 404);
        }
    }
}