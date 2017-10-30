<?php

use Illuminate\Support\Facades\Cookie;

if (!function_exists('active'))
{

    /**
     * @param array|string $route
     *
     * @return bool
     */
    function active($route)
    {
        $object = request()->route();

        return $object && in_array($object->action['as'], (array)$route, true);
    }

}

if (!function_exists('keywords'))
{
    /**
     * @param string|\Illuminate\Database\Eloquent\Model $content
     * @param bool $toArray
     *
     * @return string|array
     */
    function keywords($content = null, $toArray = false)
    {
        if (is_object($content) && \method_exists($content, 'tags'))
        {
            $mixed = [];

            foreach ($content->tags as $tag)
            {
                $mixed[] = $tag->name;
            }
        }
        else
        {
            $trim  = trim($content);
            $data  = preg_replace('~[^а-яё\w\\/]+~ui', ',', $trim);
            $mixed = explode(',', $data);

            $mixed = \Bavix\Helpers\Arr::filter($mixed, function ($str) {
                return strlen($str) > 1;
            });
        }

        $data = array_unique($mixed);

        if ($toArray)
        {
            return $data;
        }

        return implode(', ', $data);
    }
}

if (!function_exists('asset2'))
{
    function asset2($path, $secure = null)
    {
        $root = dirname(__DIR__) . '/public/';

        if (0 !== strpos($path, 'http'))
        {
            if (file_exists($root . $path))
            {
                $path .= '?' . filemtime($root . $path);
            }

            return '/' . ltrim($path, '/');
        }

        return asset($path, $secure);
    }
}

if (!function_exists('diffForHumans'))
{
    function diffForHumans($date)
    {
        $carbon = \Laravelrus\LocalizedCarbon\LocalizedCarbon::createFromFormat('Y-m-d H:i:s', $date);
        $local  = \Laravelrus\LocalizedCarbon\LocalizedCarbon::instance($carbon);

        return $local->diffForHumans();
    }
}

if (!function_exists('onOff'))
{
    function onOff($value)
    {
        if ($value)
        {
            return '<span class="label label-primary">вкл.</span>';
        }

        return '<span class="label label-default">выкл.</span>';
    }
}

if (!function_exists('bx_background'))
{
    function bx_background()
    {
        $now = \Carbon\Carbon::now();

        $background = '/image/background.png';

        if ($now->month === 10 && $now->day === 31)
        {
            $background = '/image/halloween/' . \Bavix\Helpers\Num::randomInt(1, 9) . '.png';
        }

        return asset2($background);
    }
}
