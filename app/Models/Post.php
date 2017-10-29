<?php

namespace App\Models;

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
 */
class Post extends Model
{

    use HasTags;
    use ModelURL;
    use Searchable;

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

    public function setPictureAttribute($picture, $toModel = true)
    {
        $model      = new Image();
        $model->path = $picture;
        $model->save();

        $this->id or $this->save();

        if (!$toModel)
        {
            $this->images()->save($model);

            return;
        }

        $this->image_id = $model->id;
        $this->save();
    }

    public function setGalleryAttribute($pictures)
    {
        if (is_array($pictures))
        {
            foreach ($pictures as $picture)
            {
                $this->setPictureAttribute($picture, false);
            }
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @param $files
     */
    public function setDocumentsAttribute($files)
    {
        if (is_array($files))
        {
            foreach ($files as $path)
            {
                $model        = new File();
                $model->title = \basename($path);
                $model->path   = $path;
                $model->save();

                $this->id or $this->save();
                $this->files()->save($model);
            }
        }
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function images()
    {
        return $this->morphToMany(Image::class, 'imaggable');
    }

    public function files()
    {
        return $this->morphToMany(File::class, 'filegable');
    }
}
