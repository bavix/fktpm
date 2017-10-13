<?php

namespace App\Admin\Controllers;

use App\Models\Notify;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class NotifyController extends AdminController
{

    public $title = 'Уведомления';
    public $model = Notify::class;

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

            $grid->column('content', 'Контент')
                ->display(function ($text) {
                    $content = strip_tags($text);

                    if (strlen($content) > 400)
                    {
                        $content = substr($content, 0, 400) . '...';
                    }

                    return $content;
                })
                ->sortable();

            $grid->column('active', 'Видимость')->display(function ($data) {
                return $data ? 'Включена' : 'Выключена';
            })->sortable();

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

            $form->ckeditor('content', 'Контент');

            $form->switch('active', 'Видимость');

            $form->ignore(['created_at', 'updated_at']);

        });

    }

}
