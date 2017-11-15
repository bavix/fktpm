<?php

namespace App\Models;

use Bavix\Helpers\JSON;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
