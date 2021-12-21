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

    public function getById($id)
    {
        return $this->model->getById($id);
    }

    public function stored($data)
    {
        return $this->model->insert($data);
    }

    public function update($data)
    {
        return $this->model->update($data);
    }

    public function delete($id)
    {

    }
}