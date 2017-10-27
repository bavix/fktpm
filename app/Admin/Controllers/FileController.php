<?php

namespace App\Admin\Controllers;

use App\Models\File;
use Bavix\App\Admin\Controllers\AdminController;
use Bavix\Helpers\Str;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class FileController extends AdminController
{

    public $title = 'Файлы';
    public $model = File::class;

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid(): Grid
    {
        return Admin::grid($this->model, function (Grid $grid) {
            $grid->model()->orderBy('id', 'DESC');

            $grid->id('ID')->sortable();

            $grid->column('title', 'Название')->sortable();
            $grid->column('type', 'Тип')->sortable();
            $grid->column('size', 'Размер')
                ->display(function ($size) {
                    return Str::fileSize($size);
                })
                ->sortable();

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
    protected function form($id = null): Form
    {
        return Admin::form($this->model, function (Form $form) use ($id) {

            $form->display('id', 'ID');

            $form->text('title', 'Название');
            $form->file('file', 'Файл')
                ->name(bx_uploaded_file());

            $tags = $form->tags('tag', 'Теги');

            if ($id)
            {
                $tags->options(
                    $form->model()
                        ->find($id)
                        ->tags
                        ->pluck('name')
                        ->all()
                );
            }

            $form->ignore(['created_at', 'updated_at']);

        });
    }

}
