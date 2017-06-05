<?php

namespace App\Admin\Extensions\Form;

use Encore\Admin\Form\Field;

class LightGallery extends Field
{

    /**
     * @var string
     */
    protected $view = 'vendor.admin.form.lightGallery';

    /**
     * @var array
     */
    public static $css = [
        '/packages/admin/lightGallery/css/lightgallery.min.css',
        '/packages/css/color.css'
    ];

    /**
     * @var array
     */
    public static $js = [
        '/packages/admin/lightGallery/js/lightgallery.min.js',
        '/packages/admin/lightGallery/plugins/js-trash.js',
    ];

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
//        $class        = implode('.', $this->getElementClass());
//        $this->script = "$('textarea.{$class}').ckeditor();";

        // todo добавить кнопку уделения

        $this->script = '$(\'.lightGallery\').lightGallery();';

        $column = $this->options['column'];
        $this->variables['_pictures'] = $this->form->model()->$column;

        return parent::render();
    }

}
