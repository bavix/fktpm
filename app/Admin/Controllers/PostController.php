<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\BtnPreview;
use App\Models\Category;
use App\Models\Post;
use Bavix\Helpers\Dir;
use Bavix\Helpers\Str;
use App\Facades\Admin;
use App\Accessor\Form;
use Bavix\SDK\PathBuilder;
use Encore\Admin\Grid;

class PostController extends AdminController
{

    public $category = true;
    public $title    = 'Посты';
    public $model    = Post::class;

    public $mainPage = false;

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $self = $this;

        return Admin::grid($this->model, function (Grid $grid) use ($self)
        {

            $grid->id('ID')->sortable();

            $grid->column('title', 'Название')->sortable();
            $grid->column('description', 'Описание');

            if ($self->category)
            {
                $grid->column('category.title', 'Категория')->sortable();
            }

            $grid->column('active', 'Видимость')->display(function ($data)
            {
                return $data ? 'Включена' : 'Выключена';
            })->sortable();

            if ($self->mainPage)
            {
                $grid->column('main_page', 'Главная страница')->display(function ($data)
                {
                    return $data ? 'Включена' : 'Выключена';
                })->sortable();
            }

            $grid->actions(function (Grid\Displayers\Actions $actions) use ($self)
            {

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
     * @return Form
     */
    protected function form()
    {

        $self = $this;

        return Admin::form($this->model, function (Form $form) use ($self)
        {

            $form->display('id', 'ID');

            $form->text('title', 'Заголовок');

            $form->textarea('description', 'Описание')->rows(3);
            $form->ckeditor('content', 'Текст');

            $form->image('picture', 'Изображение')
                ->name($self->buildCallable('image', 'picture'));

            $form->logo('logo', '');

            if ($this->category)
            {
                $form->select('category_id', 'Категория')->options(
                    Category::all('id', 'title')
                        ->pluck('title', 'id')
                        ->all()
                );
            }

            $form->multipleImage('gallery', 'Галерея')
                ->name($self->buildCallable('image', 'gallery'));

            $form->lightGallery('pictures', '')->options([
                'column' => 'images'
            ]);

            $form->multipleFile('documents', 'Документы')
                ->name(function (\Illuminate\Http\UploadedFile $upload)
                {
                    $path = PathBuilder::sharedInstance()
                        ->generate('', Str::random(2), Str::random(4));

                    $original = $upload->getClientOriginalName();

                    return ltrim($path, '/') . '/' . $original;
                });

            $form->documents('readable', '')->options([
                'column' => 'files'
            ]);

            if ($this->mainPage)
            {
                $form->switch('main_page', 'Главная Страница');
            }

            $form->switch('active', 'Видимость');

            $form->ignore(['created_at', 'updated_at']);

        });

    }

}
