<?php
namespace app\controllers;

use app\repository\TaskRepository;

class TaskController extends Controller
{
    public function index()
    {
        $taskRepo = new TaskRepository;
        $tasks = $taskRepo->getList();
        echo'<pre>';
        print_r($tasks);
        echo '</pre>';
    }

    public function add()
    {

    }

    public function stored()
    {

    }

    public function edit()
    {

    }

    public function updated()
    {

    }

    public function delete()
    {

    }
}