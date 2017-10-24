<?php

namespace App\Admin\Controllers;

use Bavix\Helpers\Closure;
use App\Admin\Extensions\BtnPreview;
use App\Models\Category;
use App\Models\Post;
use Bavix\Helpers\Str;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
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

        return Admin::grid($this->model, function (Grid $grid) use ($self) {
            $grid->model()->orderBy('id', 'DESC');

            $grid->id('ID')->sortable();

            $grid->column('title', 'Название')->sortable();
            $grid->column('description', 'Описание');

            if ($self->category)
            {
                $grid->column('category.title', 'Категория')->sortable();
            }

            $grid->column('active', 'Видимость')
                ->display(Closure::fromCallable('onOff'))
                ->sortable();

            if ($self->mainPage)
            {
                $grid->column('main_page', 'Главная страница')
                    ->display(Closure::fromCallable('onOff'))
                    ->sortable();
            }

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
     * @return Form
     */
    protected function form()
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

                $this->tagsBuilder($form);

                $form->image('picture', 'Изображение')
                    ->name($this->buildCallable('image', 'picture'));

                $form->logo('logo', '');

                $form->multipleImage('gallery', 'Галерея')
                    ->name($this->buildCallable('image', 'gallery'));

                $form->lightGallery('pictures', '')->options([
                    'column' => 'images'
                ]);

                $form->multipleFile('documents', 'Документы')
                    ->name(function (\Illuminate\Http\UploadedFile $upload) {
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

        });

    }

}
