<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\BtnPreview;
use App\Models\Album;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class AlbumController extends AdminController
{

    public $title = 'Альбом';
    public $model = Album::class;

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

            $grid->column('title', 'Название')->sortable();
            $grid->column('description', 'Описание');

            $grid->column('active', 'Видимость')
                ->display(\Closure::fromCallable('onOff'))
                ->sortable();

            $grid->column('created_at', 'Дата создания')->sortable();
            $grid->column('updated_at', 'Дата обновления')->sortable();

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->append(new BtnPreview($actions->getKey(), 'album.draft'));
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

        $self = $this;

        return Admin::form($this->model, function (Form $form) use ($self) {

            $form->display('id', 'ID');

            $form->text('title', 'Заголовок');

            $form->textarea('description', 'Описание')->rows(3);

            $form->image('picture', 'Изображение')
                ->name($self->buildCallable('image', 'picture'));

            $form->logo('logo', '');

            $form->multipleImage('gallery', 'Галерея')
                ->name($self->buildCallable('image', 'gallery'));

            $form->lightGallery('pictures', '')->options([
                'column' => 'images'
            ]);

            $form->switch('active', 'Видимость');

            $form->ignore(['created_at', 'updated_at']);

        });

    }

}
