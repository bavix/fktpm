<?php

namespace App\Models;

use Bavix\LaravelClickHouse\Database\Eloquent\Model;

/**
 * App\Models\Download
 *
 * @property int $fileId
 * @property string $ip
 * @property mixed $parameters
 * @property \Illuminate\Support\Carbon $date
 * @property \Illuminate\Support\Carbon $createdAt
 */
class Download extends Model
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
