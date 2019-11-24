<?php

use Illuminate\Support\Str;

// posts
Breadcrumbs::register('post', static function ($breadcrumbs) {
    $breadcrumbs->push(__('breadcrumbs.posts'), route('post'));
});

Breadcrumbs::register('post.tag', static function ($breadcrumbs) {
    $breadcrumbs->parent('post');
    $breadcrumbs->push(__('breadcrumbs.tag'), route(
        'post.tag',
        request()->route()->originalParameters()
    ));
});

Breadcrumbs::register('post.category', static function ($breadcrumbs, $item = null) {
    $breadcrumbs->parent('post');

    $categoryId = request()->route()->parameter('id');
    if ($item instanceof \App\Models\Post) {
        $categoryId = $item->category_id;
        $item = null;
    }

    if (!$item) {
        $item = \App\Models\Category::query()
            ->findOrFail($categoryId);
    }

    $breadcrumbs->push($item->title, route('post.category', [
        'id' => $item->id,
        'title' => Str::slug($item->title)
    ]));
});

Breadcrumbs::register('post.view', static function ($breadcrumbs, $item) {
    $breadcrumbs->parent('post.category', $item->category);
    $breadcrumbs->push($item->title, route('post.view', [
        'id' => $item->id,
        'title' => Str::slug($item->title)
    ]));
});

// professors
Breadcrumbs::register('professor', static function ($breadcrumbs) {
    $breadcrumbs->push(__('breadcrumbs.professor'), route('professor'));
});

// couples
Breadcrumbs::register('couple', static function ($breadcrumbs) {
    $breadcrumbs->push(__('breadcrumbs.couple'), route('couple'));
});

// helper
Breadcrumbs::register('helper', static function ($breadcrumbs) {
    $breadcrumbs->push(__('breadcrumbs.helper'), route('helper'));
});

// file
Breadcrumbs::register('file.tag', static function ($breadcrumbs) {
    $breadcrumbs->push(__('breadcrumbs.tag'), request()->fullUrl());
});
