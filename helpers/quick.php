<?php

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;

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

if (!function_exists('activeClass'))
{

    /**
     * @param string|array $route
     *
     * @return string
     */
    function activeClass($route)
    {
        return active($route) ? 'active' : '';
    }

}

if (!function_exists('bx_decrypt'))
{
    function bx_decrypt($mixed)
    {
        try
        {
            return decrypt($mixed);
        }
        catch (\Throwable $throwable)
        {
            return $mixed;
        }
    }
}

if (!function_exists('bx_cookie'))
{
    function bx_cookie($key, $default = null)
    {
        $data = Cookie::get($key, $default);

        if (is_array($data))
        {
            foreach ($data as $i => $value)
            {
                $data[$i] = bx_decrypt($value);
            }

            return $data;
        }

        return bx_decrypt($data);
    }
}

if (!function_exists('visually'))
{

    /**
     * @return bool
     */
    function visually()
    {
        return bx_cookie(__FUNCTION__, false);
    }

}

if (!function_exists('visuallyImage'))
{

    /**
     * @return bool
     */
    function visuallyImage()
    {
        return bx_cookie(__FUNCTION__, false);
    }

}

if (!function_exists('visuallyFont'))
{

    /**
     * @return bool
     */
    function visuallyFont()
    {
        return bx_cookie(__FUNCTION__, 20);
    }

}

if (!function_exists('visuallyColor'))
{

    /**
     * @return bool
     */
    function visuallyColor()
    {
        return bx_cookie(__FUNCTION__, 'black-white');
    }

}

if (!function_exists('visuallyFontString'))
{

    /**
     * @return bool
     */
    function visuallyFontString($type)
    {
        $data = visuallyFont();

        return (int)$data === $type ? 'active' : '';
    }

}

if (!function_exists('visuallyColorString'))
{

    /**
     * @return bool
     */
    function visuallyColorString($type)
    {
        $data = visuallyColor();

        return $data === $type ? 'active' : '';
    }

}

if (!function_exists('keywords'))
{
    /**
     * @param string $content
     *
     * @return string
     */
    function keywords($content)
    {
        $trim  = trim($content);
        $data  = preg_replace('~[^а-яё\w\\/]+~ui', ',', $trim);
        $mixed = explode(',', $data);
        $data  = array_unique($mixed);

        return implode(', ', $data);
    }
}

if (!function_exists('phone'))
{
    /**
     * @param string $string
     *
     * @return string
     */
    function phone($string)
    {
        $string = preg_replace('~\D+~', '', $string);

        if (strlen($string) === 10)
        {
            $string = '7' . $string;
        }

        if ($string{0} === '7')
        {
            return '+' . $string;
        }

        return $string;
    }
}

if (!function_exists('qrModel'))
{
    function qrModel($canonicalUrl)
    {
        if (!request()->route())
        {
            return false;
        }

        return \App\Models\Qr::findByUrl($canonicalUrl);
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

if (!function_exists('notifies'))
{
    function notifies()
    {
        static $data;

        if (!$data)
        {
            $data = \App\Models\Notify::query()
                ->where('active', 1)
                ->whereNotIn('id', bx_cookie('notify', []))
                ->orderBy('id', 'desc')
                ->get();
        }

        return $data;
    }
}

if (!function_exists('logo'))
{
    function logo()
    {
        $logo = \Encore\Admin\Auth\Database\Administrator::query()->first()->avatar;

        if ($logo)
        {
            return $logo;
        }

        return 'https://via.placeholder.com/255x128';
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
