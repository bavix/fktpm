<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
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
        return Admin::content(function (Content $content)
        {
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
        return Admin::content(function (Content $content) use ($id)
        {
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
        return Admin::content(function (Content $content)
        {

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
