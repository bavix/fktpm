<?php

namespace App\Admin\Extensions\Form;

use Encore\Admin\Form\Field;

class Logo extends Field
{

    /**
     * @var string
     */
    protected $view = 'vendor.admin.form.logo';

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
//        $class        = implode('.', $this->getElementClass());
//        $this->script = "$('textarea.{$class}').ckeditor();";

        // todo добавить кнопку уделения

        $image = $this->form->model()->image;

        $this->variables['_logo'] = $image->path ?? null;

        return parent::render();
    }

}
