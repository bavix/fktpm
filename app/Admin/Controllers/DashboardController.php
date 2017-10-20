<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Page;
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
        return Admin::content(function (Content $content) use ($request) {

            $content->header('Приборная панель');

            $content->row(function (Row $row) {
                $row->column(2, new InfoBox('Посты', 'newspaper-o', 'yellow', '/cp/posts', Post::query()->count()));
            });

            $content->row(function (Row $row) use ($request) {

                if (env('APP_DEBUG') || $request->query('debug', 0))
                {
                    $row->column(4, Dashboard::dependencies());
                    $row->column(4, Dashboard::environment());
                    $row->column(4, Dashboard::extensions());
                }
                else
                {
                    $row->column(4, Dashboard::environment());
                }

            });

        });
    }

}
