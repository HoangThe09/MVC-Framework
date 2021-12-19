<?php
namespace app\controllers;

use libs\View;

abstract class Controller
{
    protected $params;

    public function __construct($params)
    {
        foreach($_REQUEST as $key => $value){
            $params[$key] = $value;
        }
        $this->params = $params;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getParam($param)
    {
        foreach($this->params as $key => $value){
            if($param == $key){
                return $value;
            }
        }
    }

    public function view($view, $data = []){
        View::render($view, $data);
    }
}