<?php

namespace App\Admin\Controllers;

use App\Models\Config;
use App\Facades\Admin;
use App\Accessor\Form;
use Encore\Admin\Grid;

class ConfigController extends AdminController
{

    public $title = 'Конфигурации';
    public $model = Config::class;

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid($this->model, function (Grid $grid)
        {

            $grid->id('ID')->sortable();

            $grid->column('name', 'Ключ')->sortable();
            $grid->column('value', 'Значение')->sortable();

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

        return Admin::form($this->model, function (Form $form)
        {

            $form->display('id', 'ID');

            $form->text('name', 'Ключ');
            $form->text('value', 'Значение');

            $form->ignore(['created_at', 'updated_at']);

        });

    }

}
