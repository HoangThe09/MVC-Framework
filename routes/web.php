<?php

use app\middleware\LogMiddleware;
use libs\Router;

// Router::get('/post/index', [PostController::class, 'index']);
// Router::get('/post/get-content', [PostController::class, 'getContent']);
// Router::get('/post/add', [PostController::class, 'addPost']);
// Router::get('/post/show/{id}', [PostController::class, 'show']);
// Router::get('/test/test-middleware', [PostController::class, 'gf'], [LogMiddleware::class]);
Router::get('/tasks', [TaskController::class, 'index']);
Router::get('/tasks/add', [TaskController::class, 'add']);
Router::post('/tasks', [TaskController::class, 'stored']);
Router::get('/tasks', [TaskController::class, 'index']);
Router::get('/tasks/{id}', [TaskController::class, 'edit']);
Router::post('/tasks/{id}', [TaskController::class, 'update']);
Router::get('/tasks/delete/{id}', [TaskController::class, 'delete']);