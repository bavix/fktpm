<?php

namespace App\Models;

use App\Helpers\HasTags;
use Bavix\Helpers\PregMatch;
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
 */
class File extends Model
{

    use HasTags
    {
        tags as public tagsToMany;
    }

    /**
     * @var string
     */
    protected $table      = 'files';
    public    $timestamps = false;

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

    public function tags(): MorphToMany
    {
        return $this->tagsToMany()
            ->where('is_block', 0);
    }

}
