<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\Form\CKEditor;
use App\Http\Controllers\Controller;
use App\Models\Rev;
use Bavix\Diff\Differ;
use Bavix\Helpers\Dir;
use Bavix\Helpers\Str;
use Bavix\SDK\PathBuilder;
use Encore\Admin\Controllers\ModelForm;
use App\Facades\Admin;
use App\Accessor\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

abstract class AdminController extends Controller
{

    use ModelForm;

    public $title;
    public $model;

    protected function revsBuilder(Form $form)
    {
        $id = (int)basename($form->builder()->getAction());

        if (!$id)
        {
            return;
        }

        $class = $this->model;
        $model = $class::query()->find($id);
        $query  = Rev::fromModel($model);
        $count = $query->count();
        $revs  = $query->limit(15)->get();

        if ($count)
        {
            $form->tab('Revs', function (Form $form) use ($revs, $count, $model) {
                $content = $model->content;
                $differ  = new Differ();

                foreach ($revs as $key => $rev)
                {
                    $ver = $count - $key;

                    /**
                     * @var $ckeditor CKEditor
                     */
                    $ckeditor = $form->ckeditor('rev' . $ver, 'Версия #' . $ver);
                    $ckeditor->default($content = $differ->patch($content, $rev->patch));
                }
            });
        }
    }

    protected function buildCallable($type, $config)
    {
        return function (\Illuminate\Http\UploadedFile $uploadedFile) use ($type, $config) {
            $ext = $uploadedFile->getClientOriginalExtension();

            $path = PathBuilder::sharedInstance()
                    ->generate('', $config, Str::random()) . '.' . $ext;

            return ltrim($path, '/');
        };
    }

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header($this->title);

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     *
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header($this->title);

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header($this->title);

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    abstract protected function grid();

    /**
     * Make a form builder.
     *
     * @return Form
     */
    abstract protected function form();

}
