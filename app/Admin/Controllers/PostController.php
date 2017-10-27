<?php

namespace App\Admin\Controllers;

use Bavix\App\Admin\Controllers\AdminController;
use Bavix\Helpers\Closure;
use App\Admin\Extensions\BtnPreview;
use App\Models\Category;
use App\Models\Post;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class PostController extends AdminController
{

    public $category = true;
    public $title    = 'Посты';
    public $model    = Post::class;

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid(): Grid
    {
        $self = $this;

        return Admin::grid($this->model, function (Grid $grid) use ($self) {

            $grid->model()->orderBy('id', 'DESC');

            $grid->id('ID')->sortable();

            $grid->column('title', 'Название')->sortable();
            $grid->column('description', 'Описание');

            $grid->column('category.title', 'Категория')->sortable();

            $grid->column('active', 'Видимость')
                ->display(Closure::fromCallable('onOff'))
                ->sortable();

            $grid->column('created_at', 'Дата создания')->sortable();
            $grid->column('updated_at', 'Дата обновления')->sortable();

            $grid->actions(function (Grid\Displayers\Actions $actions) use ($self) {

                if ($self->category)
                {
                    $actions->append(new BtnPreview($actions->getKey(), 'post.draft'));
                }
                else
                {
                    $actions->append(new BtnPreview($actions->getKey(), 'page.draft'));
                }

            });

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

            $form->tab('Редактировать', function (Form $form) {

                $form->display('id', 'ID');

                $form->text('title', 'Заголовок');

                $form->textarea('description', 'Описание')->rows(3);
                $form->ckeditor('content', 'Текст');

                if ($this->category)
                {
                    $form->select('category_id', 'Категория')->options(
                        Category::all('id', 'title')
                            ->pluck('title', 'id')
                            ->all()
                    );
                }

                $form->image('picture', 'Изображение')
                    ->name(bx_uploaded_file());

                $form->logo('logo', '');

                $form->multipleImage('gallery', 'Галерея')
                    ->name(bx_uploaded_file());

                $form->lightGallery('pictures', '')->options([
                    'column' => 'images'
                ]);

                $form->switch('active', 'Видимость');

                $form->ignore(['created_at', 'updated_at']);

            });

        });

    }

}
