<?php

// posts
Breadcrumbs::register('post', function ($breadcrumbs) {
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

// professors
Breadcrumbs::register('professor', function ($breadcrumbs) {
    $breadcrumbs->push(__('breadcrumbs.professor'), route('professor'));
});

// couples
Breadcrumbs::register('couple', function ($breadcrumbs) {
    $breadcrumbs->push(__('breadcrumbs.couple'), route('couple'));
});

// helper
Breadcrumbs::register('helper', function ($breadcrumbs) {
    $breadcrumbs->push(__('breadcrumbs.helper'), route('helper'));
});

// file
Breadcrumbs::register('file.tag', function ($breadcrumbs) {
    $breadcrumbs->push(__('breadcrumbs.tag'), request()->fullUrl());
});
