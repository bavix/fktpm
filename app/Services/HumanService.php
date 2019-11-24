<?php

namespace App\Services;

use Carbon\Carbon;

class HumanService
{

    /**
     * @param Carbon $carbon
     * @return string
     */
    public function diffFor(Carbon $carbon): string
    {
        return $carbon->longRelativeToNowDiffForHumans();
    }

    /**
     * @param $size
     * @param int $decimals
     * @return string
     */
    public function fileSize($size, $decimals = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

        if ($size <= 0) {
            return 0 . ' ' . current($units);
        }

        $log = \log($size, 1024);
        $power = \min(\floor($log), \count($units));
        $postfix = $units[$power > 0 ? $power : 0];
        while ($power > 0 && $power--) {
            $size /= 1024;
        }

        return number_format($size, $decimals) . ' ' . $postfix;
    }

}
