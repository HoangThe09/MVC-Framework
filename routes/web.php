<?php

use app\middleware\LogMiddleware;
use app\middleware\CheckData;
use libs\Router;

Router::get('/', [TaskController::class, 'index']);

Router::group(['prefix' => 'tasks'], function () {
    Router::get('', [TaskController::class, 'getList']);
    Router::post('', [TaskController::class, 'stored'], [CheckData::class]);
    Router::get('/{id}', [TaskController::class, 'show']);
    Router::put('/{id}', [TaskController::class, 'update'], [CheckData::class]);
    Router::patch('/{id}', [TaskController::class, 'updateStatus']);
    Router::delete('/{id}', [TaskController::class, 'delete']);
});