<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'PageController@main')->name('home');

$url = preg_replace(
    '~(\w+://)~',
    'special.',
    env('APP_URL')
);

Route::domain($url)->group(function () {
    if (!visually()) {
        Route::get(
            request()->server('REQUEST_URI'),
            'VisuallyController@index'
        );
    }
});

// posts
Route::paginate('/posts', 'PostController@index')
    ->name('post');

Route::paginate('/posts/search/{query?}', 'PostController@search')
    ->name('post.search');

Route::get('/post/category/{id}-{title}', 'PostController@index')
    ->name('post.category');

Route::get('/post/draft/{id}-{title}.html', 'PostController@draft')
    ->name('post.draft');

Route::get('/post/{id}-{title}.html', 'PostController@view')
    ->name('post.view');

// pages
Route::paginate('/pages', 'PageController@index')
    ->name('page');

Route::paginate('/pages/search/{query?}', 'PageController@search')
    ->name('page.search');

Route::get('/page/draft/{id}-{title}.html', 'PageController@draft')
    ->name('page.draft');

Route::get('/page/{id}-{title}.html', 'PageController@view')
    ->name('page.view');

// polls
Route::paginate('/polls', 'PollController@index')
    ->name('poll');

Route::paginate('/polls/search/{query?}', 'PollController@search')
    ->name('poll.search');

Route::get('/poll/draft/{id}-{title}.html', 'PollController@draft')
    ->name('poll.draft');

Route::get('/poll/{id}-{title}.html', 'PollController@view')
    ->name('poll.view');

Route::post('/poll/{id}-{title}.html', 'PollController@view')
    ->name('poll.view');

// albumsHome
Route::paginate('/albums', 'AlbumController@index')
    ->name('album');

Route::paginate('/albums/search/{query?}', 'AlbumController@search')
    ->name('album.search');

Route::get('/album/draft/{id}-{title}.html', 'AlbumController@draft')
    ->name('album.draft');

Route::get('/album/{id}-{title}.html', 'AlbumController@view')
    ->name('album.view');

// statement
Route::get('/statement', 'StatementController@index')
    ->name('statement');

// statement store
Route::post('/statement', 'StatementController@store')
    ->name('statement.store');

// feedback
Route::get('/feedback', 'FeedbackController@index')
    ->name('feedback');

// feedback store
Route::post('/feedback', 'FeedbackController@store')
    ->name('feedback.store');

// слабовидящих
Route::get('/visually', 'VisuallyController@index')
    ->name('visually');

// слабовидящих (выкл. image)
Route::get('/visually/image', 'VisuallyController@image')
    ->name('visually.image');

// слабовидящих (выкл. font)
Route::get('/visually/font/{size}', 'VisuallyController@font')
    ->name('visually.font');

// слабовидящих (выкл. color)
Route::get('/visually/color/{color}', 'VisuallyController@color')
    ->name('visually.color');

Route::post('/notify/{id}', 'VisuallyController@notify')
    ->name('notify');

Route::get('/tracker.png', 'TrackerController@index')
    ->name('tracker');

Route::get('/statistics.html', 'TrackerController@statistics')
    ->name('statistics');

Route::get('/qr/{hash}', 'QRController@index')
    ->name('qr');

Route::get('/s/{hash}', 'ShorterController@index')
    ->name('shorter');

Route::get('/contact.html', 'ContactController@index')
    ->name('contact');

if (env('APP_DEBUG'))
{
    Route::get('/debug', 'DebugController@index')
        ->name('debug');
}

if (config('bx.auth'))
{
    Auth::routes();

    // todo
    Route::get('/user', 'UserController@index')->name('user');
}
