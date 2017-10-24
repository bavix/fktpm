<?php

namespace App\Models;

use App\Helpers\HasTags;
use App\Helpers\ModelUrl;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Post extends Model
{

    use HasTags;
    use ModelUrl;
    use Searchable;

    /**
     * @var string
     */
    protected $table    = 'posts';
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

    /**
     * Получить имя индекса для модели.
     *
     * @return string
     */
    public function searchableAs()
    {
        return $this->table . '_index';
    }

    public function setMultipleTagAttribute($tags)
    {
        $this->id or $this->save();
        $this->syncTags($tags);
    }

    public function setPictureAttribute($picture, $toModel = true)
    {
        $model      = new Image();
        $model->src = $picture;
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
                $model->src   = $path;
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
        return $this->belongsToMany(
            Image::class,
            $this->getTable() . '_images'
        );
    }

    public function files()
    {
        return $this->belongsToMany(
            File::class,
            $this->getTable() . '_files'
        );
    }

}
