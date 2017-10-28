<?php

/**
 * Laravel-admin - admin builder based on Laravel.
 *
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Encore\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Encore\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

Encore\Admin\Form::forget([
    'multipleImage',
    'multipleFile',
    'tags',
]);

\Encore\Admin\Form::extend('multipleFile', \Bavix\App\Admin\Form\Field\MultipleFile::class);
\Encore\Admin\Form::extend('multipleImage', \Bavix\App\Admin\Form\Field\MultipleImage::class);
\Encore\Admin\Form::extend('lightGallery', \App\Admin\Extensions\Form\LightGallery::class);
\Encore\Admin\Form::extend('logo', \App\Admin\Extensions\Form\Logo::class);
\Encore\Admin\Form::extend('tags', \Bavix\App\Admin\Form\Field\Tags::class);
