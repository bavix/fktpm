<?php

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

if (!function_exists('visually'))
{

    /**
     * @return bool
     */
    function visually()
    {
        return request()->cookie(__FUNCTION__);
    }

}

if (!function_exists('visuallyImage'))
{

    /**
     * @return bool
     */
    function visuallyImage()
    {
        return request()->cookie(__FUNCTION__);
    }

}

if (!function_exists('visuallyFont'))
{

    /**
     * @return bool
     */
    function visuallyFont($type)
    {
        $data = request()->cookie(__FUNCTION__);

        return $data === $type || ($data === null && $type === 20);
    }

}

if (!function_exists('visuallyColor'))
{

    /**
     * @return bool
     */
    function visuallyColor($type)
    {
        $data = request()->cookie(__FUNCTION__);

        return $data === $type || ($data === null && $type === 'black-white');
    }

}

if (!function_exists('visuallyFontString'))
{

    /**
     * @return bool
     */
    function visuallyFontString($type)
    {
        return visuallyFont($type) ? 'active' : '';
    }

}

if (!function_exists('visuallyColorString'))
{

    /**
     * @return bool
     */
    function visuallyColorString($type)
    {
        return visuallyColor($type) ? 'active' : '';
    }

}
