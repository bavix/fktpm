<?php

namespace App\Admin\Controllers;

use App\Models\Poll;
use App\Models\Question;
use App\Facades\Admin;
use Encore\Admin\Form\NestedForm;
use App\Accessor\Form;
use Encore\Admin\Grid;

class QuestionController extends AdminController
{

    public $title = 'Вопросы';
    public $model = Question::class;

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

            $grid->column('poll.title', 'Опрос')->sortable();
            $grid->column('question', 'Название')->sortable();

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

        return Admin::form($this->model, function (Form $form)
        {

            $form->display('id', 'ID');

            $form->select('poll_id', 'Опрос')
                ->options(
                    Poll::all(['id', 'title'])
                        ->pluck('title', 'id')
                        ->all()
                );

            $form->text('question', 'Вопрос');
            $form->number('count', 'Всего ответов');

            $form->hasMany('answers', 'Ответы', function (NestedForm $form)
            {
                $form->text('answer', 'Ответ');
                $form->number('count', 'Ответили');
            });

            $form->ignore(['created_at', 'updated_at']);

        });

    }

}
