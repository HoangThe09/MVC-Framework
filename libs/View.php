<?php
namespace libs;

use Jenssegers\Blade\Blade;

class View
{
    public static function render($view, $data = [])
    {
        extract($data);
        $file = "../App/Views/$view.php";
        if(file_exists($file)){
            require $file;
        }else{
            throw new \libs\HandleException("<br> View $file not found", 404);
        }
    }

    public static function renderTemplate($template, $data = [])
    {
        static $blade = null;
        if ($blade === null) {
            $blade = new Blade(dirname(__DIR__).'\app\views', dirname(__DIR__).'\cache');
        }
        echo $blade->make($template, $data)->render();
    }
}