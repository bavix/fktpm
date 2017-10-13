<?php

namespace App\Admin\Controllers;

use App\Models\Poll;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class PollController extends AdminController
{

    public $title = 'Опросы';
    public $model = Poll::class;

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

            $grid->column('title', 'Заголовок')->sortable();

            $grid->column('created_at', 'Дата создания')->sortable();
            $grid->column('updated_at', 'Дата обновления')->sortable();

            $grid->exporter(new \App\Accessor\CsvExporter());

        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {

        return Admin::form($this->model, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('title', 'Заголовок');
            $form->ckeditor('content', 'Текст');

            $form->switch('active', 'Видимость');

            $form->ignore(['created_at', 'updated_at']);

        });

    }

}
