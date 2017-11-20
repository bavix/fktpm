<?php

namespace App\Models;

use Bavix\Helpers\JSON;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Download
 *
 * @property int $id
 * @property int $file_id
 * @property string $ip
 * @property mixed $parameters
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\File $file
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

    public static function addDownload($fileId)
    {
        $req = request();

        $model             = new static();
        $model->file_id    = $fileId;
        $model->ip         = $req->ip();
        $model->parameters = JSON::encode([
            'userAgent' => $req->headers->get('User-Agent'),
            'language'  => $req->getPreferredLanguage(),
            'referer'   => $req->headers->get('referer')
        ]);

        $model->save();
    }

}
