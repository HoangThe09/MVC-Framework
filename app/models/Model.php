<?php
namespace app\models;

use app\observers\QueryObserver;
use libs\DB;

abstract class Model
{
    use QueryObserver;
    
    protected $db;
    protected $table;
    
    public function __construct()
    {
        $this->db = new DB();
        if(empty($this->table)){
            $this->setTableName();
        }
        $this->db->table = $this->table;
    }
    public function setTableName()
    {
        $class = get_class($this);
        $class = preg_replace('/([A-Z])/', ' $1',$class);
        $table = strtolower(substr($class, strrpos($class, '\\') + 1));
        $table = str_replace(' ','-',trim($table)).'s';
        $this->table = $table;
    }

    public function fetchAll($select = ['*'], $where = [], $order = ['id', 'desc'], $limit = [0, 12])
    {
        $this->beforeFetchAll($where);
        $result = $this->db->fetchAll($select, $where, $order, $limit);
        $this->afterFetchAll();
        return $result;
    }

    public function insert($data = [])
    {
        $this->beforeInsert();
        $this->db->insert($data);
        $this->afterInsert();
    }

    public function update($id, $data = [])
    {
        $this->beforeUpdate();
        $this->db->update($id, $data);
        $this->afterUpdate();
    }

    public function delete($id)
    {
        $this->beforeDelete();
        $this->db->delete($id);
        $this->afterDelete();
    }

    public function getById($id)
    {
        $result = $this->db->getById($id);
        return $result;
    }
}