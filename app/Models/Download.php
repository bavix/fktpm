<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Download
 *
 * @property int $id
 * @property int $file_id
 * @property string $ip
 * @property mixed $parameters
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\File $file
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Download newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Download newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Download query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Download whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Download whereFileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Download whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Download whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Download whereParameters($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Download whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Download extends Model
{

    /**
     * @return BelongsTo
     */
    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }

}
