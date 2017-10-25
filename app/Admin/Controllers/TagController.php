<?php

namespace App\Admin\Controllers;

use Bavix\Helpers\Closure;
use App\Models\Tag;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class TagController extends AdminController
{

    public $title = 'Теги';
    public $model = Tag::class;

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid($this->model, function (Grid $grid) {
            $grid->model()->orderBy('id', 'DESC');

            $grid->id('ID')->sortable();

            $grid->column('name', 'Тег')->sortable();
            $grid->column('is_block', 'Блок')->display(function ($bool) {
                return $bool ? 'yes' : 'no';
            });

            $grid->column('created_at', 'Дата создания')->sortable();
            $grid->column('updated_at', 'Дата обновления')->sortable();

            $grid->exporter(new \App\Accessor\CsvExporter());

        });
    }

    /**
     * Make a form builder.
     *
     * @param int $id
     *
     * @return Form
     */
    protected function form($id = null)
    {

        return Admin::form($this->model, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('name', 'Тег');

            $form->switch('is_block', 'Блок');

            $form->ignore(['created_at', 'updated_at']);

        });

    }

}
