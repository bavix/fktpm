<?php

namespace App\Models;

use App\Helpers\HasTags;
use Bavix\Helpers\PregMatch;
use Bavix\Helpers\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * App\Models\File
 *
 * @property int                                                             $id
 * @property string                                                          $title
 * @property string                                                          $src
 * @property string|null                                                     $type
 * @property string|null                                                     $hash
 * @property int                                                             $size
 * @property string                                                          $created_at
 * @property string                                                          $updated_at
 * @property-write mixed                                                     $tags
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tagsToMany
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereSrc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File withAllTags($tags, $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File withAnyTags($tags, $type = null)
 * @mixin \Eloquent
 * @property-write mixed                                                     $file
 * @property-write mixed                                                     $tag
 */
class File extends Model
{

    use HasTags;

    public $timestamps = false;

    public function url()
    {
        return route('file', [
            $this->id,
            Str::friendlyUrl($this->title),
            $this->type
        ]);
    }

    public function faType()
    {
        switch ($this->type)
        {
            // archive
            case 'zip':
                return 'fa-file-zip-o';

            case 'rar':
            case 'tar':
            case 'tgz':
            case 'gz':
                return 'fa-archive';

            // docs
            case 'pdf':
                return 'fa-file-pdf-o';

            case 'tiff':
                return 'fa-file-image-o';

            // word
            case 'doc':
            case 'docx':
            case 'rdf':
                return 'fa-file-word-o';

            // excel
            case 'xlsx':
            case 'xlsm':
            case 'xlsb':
            case 'xltx':
            case 'xltm':
            case 'xls':
            case 'xlt':
            case 'rtf':
                return 'fa-file-excel-o';

            // text
            case 'csv':
                return 'fa-file-text';

            default:
                return 'fa-file';
        }
    }

    public function setFileAttribute($path)
    {
//        \var_dump(
//            $path,
//            \Storage::disk('admin')->path($path)
//        );

        if (empty($path))
        {
            return;
        }

        $this->src  = $path;
        $this->type = PregMatch::first('~\.(\w+)$~', $path)->matches[1] ?? null;
        $this->size = \Storage::disk('admin')->size($path);
    }

    public function setTagAttribute($tags)
    {
        $this->syncTags(explode(',', $tags));
    }

    public function posts()
    {
        return $this->morphedByMany(Post::class, 'filegable');
    }

}
