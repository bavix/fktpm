<?php

use Illuminate\Routing\Router;
use Encore\Admin\Facades\Admin;

Admin::registerAuthRoutes();

// dashboard
Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    // dashboard
    $router->resource('/', \App\Admin\Controllers\DashboardController::class);

    // counters
    $router->resource('/counters', \App\Admin\Controllers\CounterController::class);

    // links
    $router->resource('/links', \App\Admin\Controllers\LinkController::class);

    // links
    $router->resource('/files', \App\Admin\Controllers\FileController::class);

    // categories
    $router->resource('/categories', \App\Admin\Controllers\CategoryController::class);

    // categories
    $router->resource('/tags', \App\Admin\Controllers\TagController::class);

    // posts
    $router->resource('/posts', \App\Admin\Controllers\PostController::class);

    // lg.trash
    $router->delete('/trash', 'App\Admin\Extensions\LG\Trash@index')
        ->name('lg.trash');

    // doc.trash
    $router->delete('/doc-trash', 'App\Admin\Extensions\Doc\Trash@index')
        ->name('doc.trash');

});
