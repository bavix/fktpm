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
    'map',
    'editor',
    'multipleImage',
    'multipleFile',
    'select',
    'multipleSelect',
    'tags',
]);

// extends
\Encore\Admin\Form::extend('ckeditor', \App\Admin\Extensions\Form\CKEditor::class);
\Encore\Admin\Form::extend('lightGallery', \App\Admin\Extensions\Form\LightGallery::class);
\Encore\Admin\Form::extend('documents', \App\Admin\Extensions\Form\Documents::class);
\Encore\Admin\Form::extend('logo', \App\Admin\Extensions\Form\Logo::class);
\Encore\Admin\Form::extend('multipleFile', \App\Admin\Extensions\MultipleFile::class);
\Encore\Admin\Form::extend('multipleImage', \App\Admin\Extensions\MultipleImage::class);

// select
\Encore\Admin\Form::extend('select', \App\Admin\Extensions\Select::class);
\Encore\Admin\Form::extend('multipleSelect', \App\Admin\Extensions\MultipleSelect::class);
\Encore\Admin\Form::extend('tags', \App\Admin\Extensions\Tags::class);
