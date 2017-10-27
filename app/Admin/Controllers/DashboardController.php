<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use App\Models\File;
use App\Models\Link;
use App\Models\Tag;
use Bavix\App\Http\Controllers\Controller;
use App\Models\Post;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\InfoBox;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        return Admin::content(function (Content $content) {

            $content->header('Приборная панель');

            $content->row(function (Row $row) {
                $row->column(2, new InfoBox('Categories', 'tag', 'aqua', '/cp/posts', Category::query()->count()));
                $row->column(2, new InfoBox('Posts', 'newspaper-o', 'yellow', '/cp/posts', Post::query()->count()));
                $row->column(2, new InfoBox('Links', 'link', 'red', '/cp/posts', Link::query()->count()));
                $row->column(2, new InfoBox('Tags', 'tags', 'gray', '/cp/posts', Tag::query()->count()));
                $row->column(2, new InfoBox('Files', 'files-o', 'green', '/cp/posts', File::query()->count()));
            });

            $content->row(function (Row $row) {

                $row->column(4, Dashboard::dependencies());
                $row->column(4, Dashboard::environment());
                $row->column(4, Dashboard::extensions());

            });

        });
    }

}
