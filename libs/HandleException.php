<?php

namespace libs;

class HandleException extends \Exception
{
    public function exceptionHandler()
    {
        http_response_code($this->getCode());
        $error = [];
        $error['status'] = $this->getCode();
        $error['message'] = $this->getMessage();
        echo json_encode($error);
        // if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        //     echo json_encode($error);
        // } else {
        //     echo "<h1>Error {$this->getCode()}</h1>";
        //     echo "<p>{$this->getMessage()}</p>";
        // }
    }
}
