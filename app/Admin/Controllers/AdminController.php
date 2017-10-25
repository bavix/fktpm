<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\Form\CKEditor;
use App\Http\Controllers\Controller;
use App\Models\Rev;
use Bavix\Diff\Differ;
use Bavix\Helpers\Str;
use Bavix\SDK\PathBuilder;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

abstract class AdminController extends Controller
{

    use ModelForm;

    public $title;
    public $model;

    private $_model;

    protected function getModel(Form $form)
    {
        if (!$this->_model)
        {
            $id = (int)basename($form->builder()->getAction());

            if (!$id)
            {
                return null;
            }

            $class        = $this->model;
            $this->_model = $class::query()->find($id);
        }

        return $this->_model;
    }

    protected function tagsBuilder(Form $form)
    {
        $model = $this->getModel($form);
        $tags  = $model ? $model->tags->pluck('name', 'name')->all() : [];

        $form->multipleSelect('multiple_tag', 'Теги')
            ->options($tags)
            ->tags();
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

            $content->body($this->form($id)->edit($id));
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
     * @param int $id
     *
     * @return Form
     */
    abstract protected function form($id = null);

}
