<?php

namespace App\Models;

use Bavix\App\Models\MultipleImageTrait;
use Bavix\Exceptions\HasTags;
use Bavix\Extensions\ModelURL;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

/**
 * App\Models\Post
 *
 * @property int                                                               $id
 * @property string                                                            $title
 * @property string                                                            $description
 * @property string                                                            $content
 * @property int|null                                                          $image_id
 * @property int                                                               $category_id
 * @property int                                                               $active
 * @property string                                                            $created_at
 * @property string                                                            $updated_at
 * @property-read \App\Models\Category                                         $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\File[]  $files
 * @property-read \App\Models\Image|null                                       $image
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Image[] $images
 * @property-write mixed                                                       $documents
 * @property-write mixed                                                       $gallery
 * @property-write mixed                                                       $multiple_tag
 * @property-write mixed                                                       $picture
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[]        $tags
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post withAllTags($tags, $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post withAnyTags($tags, $type = null)
 * @mixin \Eloquent
 * @property-write mixed $tag
 * @property string|null $instagram_code
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereInstagramCode($value)
 */
class Post extends Model
{

    use HasTags;
    use ModelURL;
    use Searchable;
    use MultipleImageTrait;

    public $timestamps = false;

    /**
     * @var string
     */
    protected $route    = 'post.view';
    protected $routeTag = 'post.tag';

    /**
     * @param $tag
     *
     * @return string
     */
    public function routeTag($tag)
    {
        return route($this->routeTag, [
            'tag' => $tag
        ]);
    }

    public function setMultipleTagAttribute($tags)
    {
        $this->id or $this->save();
        $this->syncTags($tags);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getModelImage(): string
    {
        return Image::class;
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function images()
    {
        return $this->morphToMany(Image::class, 'imaggable');
    }

}
