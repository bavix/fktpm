<?php

use Illuminate\Support\Facades\Route;

// posts
Route::get('/', 'PostController@index')
    ->name('post');

Route::get('/post/category/{category}-{title}', 'PostController@category')
    ->name('post.category');

Route::get('/post/{post}-{title}.html', 'PostController@view')
    ->name('post.view');

Route::get('/post/user/{username}', 'PostController@username')
    ->name('post.username');

Route::get('/post/tag/{tag}', 'PostController@tag')
    ->name('post.tag');

Route::get('/professors', 'ProfessorController@index')
    ->name('professor');

Route::get('/professors/rank/{professor}', 'ProfessorController@rank')
    ->name('professor.rank');

Route::get('/couples', 'CoupleController@index')
    ->name('couple');

Route::get('/help', 'HelperController@index')
    ->name('helper');

// file
Route::get('/file/{file}-{title}.{type}', 'FileController@index')
    ->name('file');

Route::get('/file/tag/{tag}', 'FileController@tag')
    ->name('file.tag');

// seo
Route::get('/helper', 'SeoController@helper');
Route::get('/donate', 'SeoController@helper');
Route::get('/teachers', 'SeoController@teacher');

Route::get('/get_file/{hash}', 'FileController@getFile');
Route::get('/professorrating/{professor}', 'ProfessorController@professorRating');
