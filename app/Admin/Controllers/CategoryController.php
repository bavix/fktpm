<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class CategoryController extends AdminController
{

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Category::class, function (Grid $grid) {
            $grid->model()->orderBy('id', 'DESC');

            $grid->id('ID')->sortable();

            $grid->column('title', 'Название')->sortable();

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

        return Admin::form(Category::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('title', 'Заголовок');

            $form->ignore(['created_at', 'updated_at']);

        });

    }

}
