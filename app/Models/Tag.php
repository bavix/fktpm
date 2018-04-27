<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Laravel\Scout\Searchable;

/**
 * App\Models\Tag
 *
 * @property int                 $id
 * @property array               $name
 * @property array               $slug
 * @property string|null         $type
 * @property int|null            $order_column
 * @property int                 $is_block
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Spatie\Tags\Tag ordered($direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereIsBlock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereOrderColumn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Spatie\Tags\Tag withType($type = null)
 * @mixin \Eloquent
 */
class Tag extends \Spatie\Tags\Tag
{

    use Searchable;

    public function posts()
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }

    public function files()
    {
        return $this->morphedByMany(File::class, 'taggable')
            ->where('active', 1)
            ->orderBy('sort', 'desc');
    }

    /**
     * @return $this
     */
    public static function blocks()
    {
        return static::with('files.tags')
            ->orderBy('order_column', 'desc')
            ->where('is_block', 1);
    }

}
