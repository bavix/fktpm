<?php

use Illuminate\Routing\Router;
use Encore\Admin\Facades\Admin;

Admin::registerAuthRoutes();

// dashboard
Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router)
{

    // dashboard
    $router->resource('/', \App\Admin\Controllers\DashboardController::class);

    // categories
    $router->resource('/types', \App\Admin\Controllers\TypeController::class);

    // counters
    $router->resource('/counters', \App\Admin\Controllers\CounterController::class);

    // trackers
    $router->resource('/trackers', \App\Admin\Controllers\TrackerController::class);

    // configs
    $router->resource('/-config', \App\Admin\Controllers\ConfigController::class);

    // questions
    $router->resource('/questions', \App\Admin\Controllers\QuestionController::class);

    // links
    $router->resource('/links', \App\Admin\Controllers\LinkController::class);

    // feedback
    $router->resource('/feedback', \App\Admin\Controllers\FeedbackController::class);
    $router->get('/feedback/doc/{id}', \App\Admin\Controllers\FeedbackController::class . '@doc')
        ->name('feedback.doc');

    // statements
    $router->resource('/statements', \App\Admin\Controllers\StatementController::class);
    $router->get('/statements/doc/{id}', \App\Admin\Controllers\StatementController::class . '@doc')
        ->name('statement.doc');

    // categories
    $router->resource('/categories', \App\Admin\Controllers\CategoryController::class);

    // posts
    $router->resource('/posts', \App\Admin\Controllers\PostController::class);

    // albums
    $router->resource('/albums', \App\Admin\Controllers\AlbumController::class);

    // polls
    $router->resource('/polls', \App\Admin\Controllers\PollController::class);

    // pages
    $router->resource('/pages', \App\Admin\Controllers\PageController::class);

    // notifies
    $router->resource('/notifies', \App\Admin\Controllers\NotifyController::class);

    // lg.trash
    $router->delete('/trash', 'App\Admin\Extensions\LG\Trash@index')
        ->name('lg.trash');

    // doc.trash
    $router->delete('/doc-trash', 'App\Admin\Extensions\Doc\Trash@index')
        ->name('doc.trash');

});
