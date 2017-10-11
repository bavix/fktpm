<?php

namespace App\Helpers;

abstract class Diff
{

    /**
     * @param string $data
     *
     * @return string
     */
    protected static function str($data): string
    {
        return $data;
    }

    /**
     * @param string $oldData
     * @param string $newData
     *
     * @return string
     */
    public static function diff($oldData, $newData)
    {
        return \xdiff_string_rabdiff(
            static::str($oldData),
            static::str($newData)
        );
    }

    /**
     * @param string $data
     * @param string $patch
     *
     * @return string
     */
    public static function patch($data, $patch)
    {
        return \xdiff_string_bpatch(
            static::str($data),
            static::str($patch)
        );
    }

}
