<?php
namespace app\controllers;

use app\repository\TaskRepository;

class TaskController extends Controller
{
    public function index()
    {
        $taskRepo = new TaskRepository;
        $tasks = $taskRepo->getList();
        // echo'<pre>';
        // print_r($tasks);
        // echo '</pre>';
        
    }

    public function add()
    {
        echo '<form action="/tasks" method = "post">
        <input type="text" name="sss" id="">
        <input type="submit" name="hs" id="">
        </form>';
    }

    public function stored()
    {
        $taskRepo = new TaskRepository;
        $data = [
            'title' => 'title',
            'description' => 'description',
            'expiration_time' => date('Y-m-d H:i:s'),
            'created_time' => date('Y-m-d H:i:s'),
            'updated_time' => date('Y-m-d H:i:s'),
        ];
        echo __METHOD__;
        // $taskRepo->stored($data);
    }

    public function edit()
    {
        $taskRepo = new TaskRepository;
        $id = $this->getParam('id');
        $task = $taskRepo->getById($id);
        echo'<pre>';
        print_r($task);
        echo '</pre>';
    }

    public function updated()
    {
        $taskRepo = new TaskRepository;
        $id = $this->getParam('id');
        $data = [
            'title' => 'title',
            'description' => 'description',
            'expiration_time' => date('Y-m-d H:i:s'),
            'created_time' => date('Y-m-d H:i:s'),
            'updated_time' => date('Y-m-d H:i:s'),
        ];
        // $taskRepo->update($id, $data);
    }

    public function delete()
    {

    }
}