<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Feedback;
use App\Models\Post;
use App\Models\Page;
use App\Models\Poll;
use App\Models\Statement;
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

                $row->column(2, new InfoBox('Подача заявлений', 'users', 'aqua', '/cp/statements', Statement::query()->count()));

                $row->column(2, new InfoBox('Посты', 'newspaper-o', 'yellow', '/cp/posts', Post::query()->count()));

                $row->column(2, new InfoBox('Обратная связь', 'hashtag', 'red', '/cp/feedback', Feedback::query()->count()));

                $row->column(2, new InfoBox('Опросы', 'question-circle', 'gray', '/cp/polls', Poll::query()->count()));

                $row->column(2, new InfoBox('Страницы', 'file-text', 'blue', '/cp/pages', Page::query()->count()));

                $row->column(2, new InfoBox('Альбомы', 'picture-o', 'green', '/cp/albums', Album::query()->count()));

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
