<?php

namespace App\Admin\Controllers;

use App\Models\Tracker;
use Bavix\Helpers\JSON;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Laravelrus\LocalizedCarbon\LocalizedCarbon;

class TrackerController extends AdminController
{

    public $title = 'Трекер';
    public $model = Tracker::class;

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

            $grid->column('ip', 'IP адрес')
                ->display(function ($ip) {
                    return '<span class="badge bg-green">' . $ip . '</span>';
                })
                ->sortable();

            $grid->column('url', 'Куда')
                ->display(function ($url) {
                    return '<span class="badge bg-blue">' . $url . '</span>';
                });

            $grid->column('parameters', 'Параметры')
                ->display(function ($json) {
                    return JSON::decode($json);
                });

            $grid->column('created_at', 'Время визита')
                ->display(function ($dateTime) {
                    $carbon = LocalizedCarbon::createFromFormat('Y-m-d H:i:s', $dateTime);
                    $local  = LocalizedCarbon::instance($carbon);

                    return '<span class="badge bg-yellow">' . $local->diffForHumans() . '</span>';
                });

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

            $form->ip('ip', 'IP');
            $form->text('url', 'Куда');
            $form->textarea('parameters', 'Параметры')->readOnly();

            $form->ignore(['created_at', 'updated_at']);

        });

    }

}
