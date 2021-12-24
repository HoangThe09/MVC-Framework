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

    public function stored($data, &$newId)
    {
        return $this->model->insert($data, $newId);
    }

    public function update($id, $data)
    {
        return $this->model->update($id, $data);
    }

    public function delete($id)
    {
        return $this->model->delete($id);
    }
}