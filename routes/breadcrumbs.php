<?php

// home
Breadcrumbs::register('home', function ($breadcrumbs) {
    $breadcrumbs->push(__('breadcrumbs.home'), route('home'));
});

Breadcrumbs::register('login', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('breadcrumbs.signIn'), route('login'));
});

Breadcrumbs::register('register', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('breadcrumbs.signUp'), route('register'));
});


// posts
Breadcrumbs::register('post', function ($breadcrumbs) {
    $breadcrumbs->parent('home');

    $breadcrumbs->push(__('breadcrumbs.posts'), route('post'));
});

Breadcrumbs::register('post.search', function ($breadcrumbs) {
    $breadcrumbs->parent('post');
    $breadcrumbs->push(__('breadcrumbs.search'), route('post.search'));
});

Breadcrumbs::register('post.tag', function ($breadcrumbs) {
    $breadcrumbs->parent('post');
    $breadcrumbs->push(__('breadcrumbs.tag'), route(
        'post.tag',
        request()->route()->parameters()
    ));
});

Breadcrumbs::register('post.category', function ($breadcrumbs, $id = null) {
    $breadcrumbs->parent('post');

    $categoryId = $id ?: request()->route()->parameter('id');
    $category   = \App\Models\Category::query()->findOrFail($categoryId);

    $breadcrumbs->push($category->title, route('post.category', [
        'id'    => $category->id,
        'title' => \Bavix\Helpers\Str::friendlyUrl($category->title)
    ]));
});

Breadcrumbs::register('post.view', function ($breadcrumbs, $item) {
    $breadcrumbs->parent('post.category', $item->category_id);
    $breadcrumbs->push($item->title, route('post.view', [
        'id'    => $item->id,
        'title' => \Bavix\Helpers\Str::friendlyUrl($item->title)
    ]));
});

Breadcrumbs::register('post.draft', function ($breadcrumbs, $item) {
    $breadcrumbs->parent('post.category', $item->category_id);
    $breadcrumbs->push(__('breadcrumbs.draft'), route('post.draft', [
        'id'    => $item->id,
        'title' => \Bavix\Helpers\Str::friendlyUrl($item->title)
    ]));
});

// pages
Breadcrumbs::register('page', function ($breadcrumbs) {
    $breadcrumbs->parent('home');

    $breadcrumbs->push(__('breadcrumbs.pages'), route('page'));
});

Breadcrumbs::register('page.search', function ($breadcrumbs) {
    $breadcrumbs->parent('page');
    $breadcrumbs->push(__('breadcrumbs.search'), route('page.search'));
});

Breadcrumbs::register('page.tag', function ($breadcrumbs) {
    $breadcrumbs->parent('page');
    $breadcrumbs->push(__('breadcrumbs.tag'), route(
        'page.tag',
        request()->route()->parameters()
    ));
});

Breadcrumbs::register('page.view', function ($breadcrumbs, $item) {
    $breadcrumbs->parent('page');
    $breadcrumbs->push($item->title, route('page.view', [
        'id'    => $item->id,
        'title' => \Bavix\Helpers\Str::friendlyUrl($item->title)
    ]));
});

Breadcrumbs::register('page.draft', function ($breadcrumbs, $item) {
    $breadcrumbs->parent('page', $item->category_id);
    $breadcrumbs->push(__('breadcrumbs.draft'), route('page.draft', [
        'id'    => $item->id,
        'title' => \Bavix\Helpers\Str::friendlyUrl($item->title)
    ]));
});

// Альбомы
Breadcrumbs::register('album', function ($breadcrumbs) {
    $breadcrumbs->parent('home');

    $breadcrumbs->push(__('breadcrumbs.albums'), route('album'));
});

Breadcrumbs::register('album.search', function ($breadcrumbs) {
    $breadcrumbs->parent('album');
    $breadcrumbs->push(__('breadcrumbs.search'), route('album.search'));
});

Breadcrumbs::register('album.tag', function ($breadcrumbs) {
    $breadcrumbs->parent('album');
    $breadcrumbs->push(__('breadcrumbs.tag'), route(
        'album.tag',
        request()->route()->parameters()
    ));
});

Breadcrumbs::register('album.view', function ($breadcrumbs, $item) {
    $breadcrumbs->parent('album');
    $breadcrumbs->push($item->title, route('album.view', [
        'id'    => $item->id,
        'title' => \Bavix\Helpers\Str::friendlyUrl($item->title)
    ]));
});

Breadcrumbs::register('album.draft', function ($breadcrumbs, $item) {
    $breadcrumbs->parent('album', $item->category_id);
    $breadcrumbs->push(__('breadcrumbs.draft'), route('album.draft', [
        'id'    => $item->id,
        'title' => \Bavix\Helpers\Str::friendlyUrl($item->title)
    ]));
});

// polls
Breadcrumbs::register('poll', function ($breadcrumbs) {
    $breadcrumbs->parent('home');

    $breadcrumbs->push(__('breadcrumbs.polls'), route('poll'));
});

Breadcrumbs::register('poll.search', function ($breadcrumbs) {
    $breadcrumbs->parent('poll');
    $breadcrumbs->push(__('breadcrumbs.search'), route('poll.search'));
});

Breadcrumbs::register('poll.tag', function ($breadcrumbs) {
    $breadcrumbs->parent('poll');
    $breadcrumbs->push(__('breadcrumbs.tag'), route(
        'poll.tag',
        request()->route()->parameters()
    ));
});

Breadcrumbs::register('poll.view', function ($breadcrumbs, $item) {
    $breadcrumbs->parent('poll');
    $breadcrumbs->push($item->title, route('poll.view', [
        'id'    => $item->id,
        'title' => \Bavix\Helpers\Str::friendlyUrl($item->title)
    ]));
});

Breadcrumbs::register('poll.draft', function ($breadcrumbs, $item) {
    $breadcrumbs->parent('poll', $item->category_id);
    $breadcrumbs->push(__('breadcrumbs.draft'), route('poll.draft', [
        'id'    => $item->id,
        'title' => \Bavix\Helpers\Str::friendlyUrl($item->title)
    ]));
});

// statement
Breadcrumbs::register('statement', function ($breadcrumbs) {
    $breadcrumbs->parent('home');

    $breadcrumbs->push(__('breadcrumbs.statement'), route('statement'));
});

// feedback
Breadcrumbs::register('feedback', function ($breadcrumbs) {
    $breadcrumbs->parent('home');

    $breadcrumbs->push(__('breadcrumbs.feedback'), route('feedback'));
});

// contact
Breadcrumbs::register('contact', function ($breadcrumbs) {
    $breadcrumbs->parent('home');

    $breadcrumbs->push(__('breadcrumbs.contact'), route('contact'));
});

// statistics
Breadcrumbs::register('statistics', function ($breadcrumbs) {
    $breadcrumbs->parent('home');

    $breadcrumbs->push(__('breadcrumbs.statistics'), route('statistics'));
});
