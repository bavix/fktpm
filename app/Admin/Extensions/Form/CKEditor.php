<?php

namespace App\Admin\Extensions\Form;

use Encore\Admin\Form\Field;

class CKEditor extends Field
{

    /**
     * @var string
     */
    protected $view = 'vendor.admin.form.ckeditor';

    /**
     * @var array
     */
    public static $js = [
        '/vendor/laravel-admin/ckeditor/ckeditor.js',
        '/vendor/laravel-admin/ckeditor/adapters/jquery.js'
    ];

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        $class        = implode('.', $this->getElementClass());
        $this->script = "$('textarea.{$class}').ckeditor();";

        return parent::render();
    }

}
