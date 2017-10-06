<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\BtnPrint;
use App\Models\Statement;
use App\Models\Type;
use App\Facades\Admin;
use App\Accessor\Form;
use Encore\Admin\Grid;
use Illuminate\Http\Request;

class StatementController extends AdminController
{

    public $title = 'Подача заявлений';
    public $model = Statement::class;

    protected function doc(Request $request, $id)
    {
        return view('docs.statement', Statement::with(['type'])->findOrFail($id));
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid($this->model, function (Grid $grid)
        {
            $grid->model()->orderBy('id', 'DESC');

            $grid->id('ID')->sortable();

            $grid->column('type.title', 'Кружок')->sortable();
            $grid->column('parent_name', 'ФИО (родитель)')->sortable();
            $grid->column('children_name', 'ФИО (ребенок)')->sortable();
            $grid->column('phone', 'Телефон')->sortable();

            $grid->column('created_at', 'Дата подачи')->sortable();

            $grid->exporter(new \App\Accessor\CsvExporter());

            $grid->actions(function (Grid\Displayers\Actions $actions)
            {
                $actions->append(new BtnPrint($actions->getKey(), 'statement.doc'));
            });

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

            $form->select('type_id', 'Кружок')->options(
                Type::all(['id', 'title'])->pluck('title', 'id')->all()
            );

            $form->text('parent_name', 'ФИО (родитель)');
            $form->text('phone', 'Телефон');

            $form->text('passport_serial', 'Серия паспорта');
            $form->text('passport_number', 'Номер паспорта');
            $form->text('passport_from', 'Кем выдан');
            $form->text('passport_division', 'Код подразделения');
            $form->date('passport_date', 'Дата выдачи');

            $form->text('registration_address', 'Адрес регистрации');
            $form->text('residential_address', 'Адрес проживания');

            $form->text('children_name', 'ФИО (ребенок)');
            $form->text('children_doc_type', 'Документ');
            $form->text('children_doc_serial', 'Серия');
            $form->text('children_doc_number', 'Номер');
            $form->text('children_school', 'Школа');
            $form->text('children_сlass', 'Класс');

            $form->ignore([
                'created_at',
                'updated_at'
            ]);

        });

    }

}
