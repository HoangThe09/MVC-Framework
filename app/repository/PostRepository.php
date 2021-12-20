<?php
namespace app\repository;

use app\models\Post;

class PostRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Post;
    }

    public function fetchAll(){
        $posts = $this->model->fetchAll();
        return $posts;
    }

    public function getById($id)
    {
        $post = $this->model->getById($id);
        return $post;
    }

    public function findByUrl($url){
        $posts = $this->model->where(['url',  '=' ,$url])->get();
        return $posts;
    }

    public function stored($data = [])
    {
        $posts = $this->model->insert($data);
        return $posts;
    }

    public function delete($id)
    {
        return $this->model->delete($id);
    }

    
}