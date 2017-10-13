<?php

namespace App\Models;

use Bavix\Helpers\JSON;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class Tracker extends Model
{

    protected $table      = 'trackers';
    public    $timestamps = false;

    protected static $_hit;
    protected static $_host;
    protected static $_online;

    public static function visits($canonicalUrl = null)
    {
        return static::query()
            ->where('url', $canonicalUrl ?: request()->getPathInfo())
            ->count();
    }

    protected static function isHit()
    {
        $time    = microtime(true);
        $newTime = $time + 0.6; // remove n-e hits

        $save = $time > session('time', 0);

        request()->session()->put(
            'time',
            $newTime
        );

        return $save;
    }

    public static function graphHost($interval = 0)
    {
        return static::query()
            ->select(
                DB::raw('sum(1) `res`'),
                'r1.day'
            )
            ->from(
                DB::raw('(' .
                    static::query()
                        ->select(
                            'ip',
                            DB::raw('DATE_FORMAT(`created_at`, "%d.%m.%Y") `day`')
                        )
                        ->where(
                            DB::raw('EXTRACT(YEAR_MONTH FROM `created_at`)'),
                            DB::raw('EXTRACT(YEAR_MONTH FROM DATE_SUB(CURDATE(), INTERVAL ' . $interval . ' MONTH))')
                        )
                        ->groupBy('ip', 'day')
                        ->toSql() . ') r1'
                )
            )
            ->groupBy('day')
            ->orderBy('day')
            ->get();
    }

    /**
     * add hit
     */
    public static function hit()
    {
        $req = request();

        if (!$req->ajax() && $req->isMethod('GET') && static::isHit())
        {
            if ($req->headers->has('User-Agent'))
            {
                $route = $req->route();

                $model             = new static();
                $model->ip         = $req->ip();
                $model->url        = $req->getPathInfo();
                $model->parameters = JSON::encode([
                    'attributes' => $route->parameters(),
                    'userAgent'  => $req->headers->get('User-Agent'),
                    'language'   => $req->getPreferredLanguage(),
                    'referer'    => $req->headers->get('referer'),
                    'route'      => $route->getName(),
                ]);

                $model->save();
            }
        }
    }

    /**
     * @return Builder
     */
    protected static function buildQuery()
    {
        return static::query()
            ->where(
                DB::raw('DATE(`created_at`)'),
                DB::raw('CURRENT_DATE')
            );
    }

    /**
     * @return int
     */
    public static function hostAllCount()
    {
        return static::query()
            ->from(
                DB::raw('(' . static::query()
                        ->select(DB::raw('`ip`'))
                        ->groupBy(DB::raw('DATE(`created_at`)'), 'ip')
                        ->toSql() . ') a')
            )->count();
    }

    /**
     * @return int
     */
    public static function hitAllCount()
    {
        return static::query()->count();
    }

    /**
     * @return int
     */
    public static function hitCount()
    {
        if (static::$_hit === null)
        {
            static::$_hit = static::buildQuery()->count();
        }

        return static::$_hit;
    }

    /**
     * @return int
     */
    public static function hostCount()
    {
        if (static::$_host === null)
        {
            static::$_host = static::buildQuery()
                ->select('ip')
                ->groupBy('ip')
                ->get()
                ->count();
        }

        return static::$_host;
    }

    /**
     * @return int
     */
    public static function onlineCount()
    {
        if (static::$_online === null)
        {
            static::$_online = static::query()
                ->select('ip')
                ->groupBy('ip')
                ->where(
                    'created_at',
                    '>',
                    DB::raw('DATE_SUB(NOW(), INTERVAL 5 MINUTE)')
                )
                ->get()
                ->count();
        }

        return static::$_online;
    }

}
