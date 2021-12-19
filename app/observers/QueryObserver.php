<?php
namespace app\observers;

trait QueryObserver
{
    public function beforeInsert()
    {

    }

    public function afterInsert()
    {

    }

    public function beforeFetchAll(&$where)
    {
        // if(empty($where)){
        //     $where = ['is_deleted', 0];
        // }else if(!empty($where) && is_array($where)){
        //     if(is_string($where[0])){
        //         $where = [['is_deleted', 0], $where];
        //     }else{
        //         array_unshift($where, ['is_deleted', 0]);
        //     }
        // }
    }   

    public function afterFetchAll()
    {
        
    }
    public function beforeUpdate()
    {

    }

    public function afterUpdate()
    {

    }

    public function beforeDelete()
    {

    }

    public function afterDelete()
    {

    }
}