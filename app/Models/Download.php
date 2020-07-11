<?php

namespace App\Models;

use Bavix\Prof\Models\Entry;

/**
 * App\Models\Download
 *
 * @property int $fileId
 * @property string $ip
 * @property mixed $parameters
 * @property \Illuminate\Support\Carbon $date
 * @property \Illuminate\Support\Carbon $createdAt
 */
class Download extends Entry
{

    /**
     * @var string[]
     */
    protected $fillable = [
        'fileId',
        'ip',
        'parameters',
        'date',
        'createdAt',
    ];

}
