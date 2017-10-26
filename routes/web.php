<?php

use Illuminate\Support\Facades\Route;

// posts
Route::paginate('/', 'PostController@index')
    ->name('post');

Route::paginate('/posts/search/{query?}', 'PostController@search')
    ->name('post.search');

Route::paginate('/post/tag/{tag}', 'PostController@tag')
    ->name('post.tag');

Route::paginate('/post/category/{id}-{title}', 'PostController@index')
    ->name('post.category');

Route::get('/post/draft/{id}-{title}.html', 'PostController@draft')
    ->name('post.draft');

Route::get('/post/{id}-{title}.html', 'PostController@view')
    ->name('post.view');

Route::get('/professors', 'ProfessorController@index')
    ->name('professor');

Route::get('/professors/rank/{id}', 'ProfessorController@rank')
    ->name('professor.rank');

Route::get('/couples', 'CoupleController@index')
    ->name('couple');

Route::get('/helper', 'HelperController@index')
    ->name('helper');

// search
Route::redirect('/search', '/search/posts');

Route::get('/search/{action}', 'SearchController@index')
    ->name('search');
