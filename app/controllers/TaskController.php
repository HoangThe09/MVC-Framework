<?php
namespace app\controllers;

use app\repository\TaskRepository;
use libs\HandleException;

class TaskController extends Controller
{
    public function index()
    {
        $this->render('task/index', []);
    }
    
    public function getList(){
        $taskRepo = new TaskRepository;
        $tasks = $taskRepo->getList();
        echo json_encode($tasks);
    }
    
    public function stored()
    {
        $title = $this->getParam('title');
        $description = $this->getParam('description');
        $expiration = $this->getParam('expiration');
        $status = $this->getParam('status');
        
        $taskRepo = new TaskRepository;
        $id = '';
        $date = date('Y-m-d H:i:s');
        $data = [
            'title' => htmlspecialchars($title, ENT_QUOTES),
            'description' => htmlspecialchars($description,ENT_QUOTES),
            'expiration_time' => $expiration,
            'status' => $status,
            'created_time' => $date,
            'updated_time' => $date,
        ];
        
        if($taskRepo->stored($data, $id)){
            echo json_encode("success");
        }else{
            throw new HandleException('Error', 500);
        }
    }

    public function show()
    {
        $taskRepo = new TaskRepository;
        $id = $this->getParam('id');
        $task = $taskRepo->getById($id);
        if($task){
            echo json_encode($task);
        }else{
            throw new HandleException('Not found post', 404);
        }
    }

    public function update()
    {
        $taskRepo = new TaskRepository;
        $id = $this->getParam('id');
        $title = urldecode($this->getParam('title'));
        $description = urldecode($this->getParam('description'));
        $expiration = urldecode($this->getParam('expiration'));
        $status = $this->getParam('status');
        $date = date('Y-m-d H:i:s');
        $data = [
            'title' => htmlspecialchars($title, ENT_QUOTES),
            'description' => htmlspecialchars($description, ENT_QUOTES),
            'expiration_time' => $expiration,
            'updated_time' => $date,
            'status' => $status,
        ];
        
        if($taskRepo->update($id, $data)){
            $data['id'] = $id;
            echo json_encode($data);
        }else{
            throw new HandleException('Error', 500);
        }
    }

    public function updateStatus()
    {
        $id = $this->getParam('id');
        $status = $this->getParam('status');
        $data = [
            'id' => $id,
            'status' => $status,
        ];
        $taskRepo = new TaskRepository;
        if($taskRepo->update($id, $data)){
            $data['id'] = $id;
            echo json_encode($data);
        }else{
            throw new HandleException('Error', 500);
        }
    }

    public function delete()
    {
        $taskRepo = new TaskRepository;
        $id = $this->getParam('id');
        $tasks = $taskRepo->getList(['id'], ['id', $id]);
        if($taskRepo->delete($id) && $tasks){
            echo json_encode("success");
        }else{
            throw new libs\HandleException('Error', 500);
        }
    }
}