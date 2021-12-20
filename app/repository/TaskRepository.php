<?php
namespace app\repository;

use app\models\Task;

class TaskRepository
{
    protected $model; 

    public function __construct()
    {
        $this->model = new Task;
    }

    public function getList($select = ['*'], $where = [], $order = ['id', 'desc'], $limit = [0, 12])
    {
        return $this->model->fetchAll($select, $where, $order, $limit);
    }

    public function getId($id)
    {

    }

    public function update($data)
    {

    }

    public function delete($id)
    {

    }
}