<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use Bavix\App\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class CategoryController extends AdminController
{

    protected $title = 'Категории';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid(): Grid
    {
        return Admin::grid(Category::class, function (Grid $grid) {
            $grid->model()->orderBy('id', 'DESC');

            $grid->id('ID')->sortable();

            $grid->column('title', 'Название')
                ->editable()
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

        return Admin::form(Category::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('title', 'Заголовок');

            $form->ignore(['created_at', 'updated_at']);

        });

    }

}
