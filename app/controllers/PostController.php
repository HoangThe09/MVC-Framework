<?php

namespace app\controllers;

use app\repository\PostRepository;

class PostController extends Controller
{

    public function index()
    {
        $postRepo = new PostRepository;
        $posts = $postRepo->fetchAll();
        $this->view('post/index', ['posts' => $posts]);
    }

    public function getContent()
    {
        $url = $this->getParam('newsUrl');
        if(preg_match("/^((https:\/\/)|(http:\/\/)).+/", $url)){
            $_SESSION['stored'] = false;
            $postDB = new PostRepository;
            $posts = $postDB->findByUrl($url);
            if($posts){
                $title = $posts[0]['title'];
                $description = $posts[0]['description'];
                $img = $posts[0]['img'];
            }else{
                $data = file_get_contents($url);
                $pattern = "/<h1 class=\"title-detail\">(.*)<\/h1>.*<p class=\"description\">(.*)<\/p>.*<picture>.*data-src=\"(.*)\"/sU";
                preg_match($pattern, $data, $match);
                $title = $match[1] ?? null;
                $description = $match[2] ?? null;
                $img = $match[3] ?? null;
                $_SESSION['stored'] = true;
                $_SESSION['title'] = htmlentities($title, ENT_QUOTES);
                $_SESSION['description'] = htmlentities($description, ENT_QUOTES);
                $_SESSION['img'] = $img;
                $_SESSION['url'] = $url;
            }
            $data = [
                'title' => $title,
                'description' => $description,
                'img' => $img,
                'url' => $url,
            ];
            $this->view('post/result', $data);
        }
    }

    public function addPost()
    {
        if($this->getParam('save') && $_SESSION['stored']){
            $data = [
                'title' => $_SESSION['title'],
                'description' => $_SESSION['description'],
                'img' => $_SESSION['img'],
                'url' => $_SESSION['url'],
            ];
            $postDB = new PostRepository;
            $postDB->stored($data);
            echo 1;
        }
    }

    public function show()
    {
        $id = $this->getParam('id');
        $postDB = new Post;
        $post = $postDB->getById($id);
        echo file_get_contents($post['url']);
    }

    public function test()
    {
        echo __METHOD__;
    }
}
