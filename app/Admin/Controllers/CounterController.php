<?php

namespace App\Admin\Controllers;

use Bavix\App\Admin\Controllers\AdminController;
use Bavix\Helpers\Closure;
use App\Models\Counter;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class CounterController extends AdminController
{

    public $title = 'Счётчики';
    public $model = Counter::class;

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

            $grid->column('active', 'Видимость')
                ->display(Closure::fromCallable('onOff'))
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

        return Admin::form($this->model, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('title', 'Заголовок');

            $form->textarea('code', 'Код счётчика')->rows(6);

            $form->switch('active', 'Видимость');

            $form->ignore(['created_at', 'updated_at']);

        });

    }

}
