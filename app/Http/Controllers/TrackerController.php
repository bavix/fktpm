<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Feedback;
use App\Models\Link;
use App\Models\Post;
use App\Models\Page;
use App\Models\Poll;
use App\Models\Statement;
use App\Models\Tracker;
use Bavix\Helpers\JSON;
use Intervention\Image\Facades\Image;
use Intervention\Image\Imagick\Font;

class TrackerController extends Controller
{

    public function statistics()
    {
        $graphCurrent = Tracker::graphHost()->pluck('res', 'day')
            ->toArray();

        $graphLast = Tracker::graphHost(1)->pluck('res', 'day')
            ->toArray();

        return $this->render('tracker.statistics', [

            'title' => 'Статистика сайта',

            'description' => 'На данной странице содержится вся статистика сайта',

            'chartLabels'      => JSON::encode(\range(1, 31)),
            'chartDataCurrent' => JSON::encode(array_values($graphCurrent)),
            'chartDataLast'    => JSON::encode(array_values($graphLast)),

            'newCount' => Post::query()
                ->where('active', 1)
                ->count(),

            'pageCount' => Page::query()
                ->where('active', 1)
                ->where('main_page', 0)
                ->count(),

            'albumCount' => Album::query()
                ->where('active', 1)
                ->count(),

            'linkCount' => Link::query()
                ->where('active', 1)
                ->count(),

            'pollCount' => Poll::query()
                ->where('active', 1)
                ->count(),

            'statementCount' => Statement::query()->count(),

        ], $this->mergeData());
    }

    public function index()
    {
        /**
         * @var $img \Intervention\Image\Image
         */
        $img = Image::canvas(88, 31, QRController::hex());

        $img->text('hosts: ' . Tracker::hostAllCount(), 2, 9, function (Font $font) {
            $font->file(config('tracker.font'));
            $font->size(9);
            $font->color('#fff');
        });

        $img->text('hits: ' . Tracker::hitAllCount(), 2, 19, function (Font $font) {
            $font->file(config('tracker.font'));
            $font->size(9);
            $font->color('#fff');
        });

        $img->text('online: ' . Tracker::onlineCount(), 2, 28, function (Font $font) {
            $font->file(config('tracker.font'));
            $font->size(9);
            $font->color('#fff');
        });

        $img->text('bavix.ru', 49, 28, function (Font $font) {
            $font->file(config('tracker.font'));
            $font->size(9);
            $font->color('#ccc');
        });

        return $img->response('png');
    }

}
