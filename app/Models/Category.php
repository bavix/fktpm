<?php

namespace App\Models;

use Bavix\Extensions\ModelURL;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Category
 *
 * @property int                                                              $id
 * @property string                                                           $title
 * @property string                                                           $created_at
 * @property string                                                           $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Post[] $posts
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category extends Model
{

    use ModelURL;

    protected $route      = 'post.category';
    public    $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

}
