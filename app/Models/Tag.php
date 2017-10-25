<?php

namespace App\Models;

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

    public function posts()
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }

    public function files()
    {
        return $this->morphedByMany(File::class, 'taggable')
            ->orderBy('id');
    }

    public static function blocks()
    {
        return static::with('files.tags')
            ->orderBy('order_column', 'desc')
            ->where('is_block', 1)
            ->get();
    }

}
