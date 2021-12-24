<?php
namespace app\controllers;

use app\repository\TaskRepository;

class TaskController extends Controller
{
    public function index()
    {
        $taskRepo = new TaskRepository;
        $tasks = $taskRepo->getList();
        $this->render('task/index', ['tasks' => $tasks]);
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
        $title = $this->getParam('title');
        $description = $this->getParam('description');
        $expiration = $this->getParam('expiration');
        $taskRepo = new TaskRepository;
        $id = '';
        $data = [
            'title' => $title,
            'description' => $description,
            'expiration_time' => $expiration,
            'created_time' => date('Y-m-d H:i:s'),
            'updated_time' => date('Y-m-d H:i:s'),
        ];
        if(!$title || !$description || $expiration){
            echo 0;
            return 0;
        }
        if($taskRepo->stored($data, $id)){
            $tasks = $taskRepo->getList();
             $this->render('task/list', ['tasks' => $tasks]);
        }else{
            echo 0;
        }
    }

    public function edit()
    {
        $taskRepo = new TaskRepository;
        $id = $this->getParam('id');
        $task = $taskRepo->getById($id);
        echo json_encode($task);
    }

    public function update()
    {
        $taskRepo = new TaskRepository;
        $id = $this->getParam('id');
        $title = $this->getParam('title');
        $description = $this->getParam('description');
        $expiration = $this->getParam('expiration');
        $data = [
            'title' => $title,
            'description' => $description,
            'expiration_time' => $expiration,
            'created_time' => date('Y-m-d H:i:s'),
            'updated_time' => date('Y-m-d H:i:s'),
        ];
        if($taskRepo->update($id, $data)){
            $data['id'] = $id;
            echo json_encode($data);
        }else{
            echo 0;
        }
    }

    public function delete()
    {
        $taskRepo = new TaskRepository;
        $id = $this->getParam('id');
        $tasks = $taskRepo->getList(['id'], ['id', $id]);
        if($taskRepo->delete($id) && $tasks){
            $tasks = $taskRepo->getList();
             $this->render('task/list', ['tasks' => $tasks]);
        }else{
            echo 0;
        }
        
    }
}