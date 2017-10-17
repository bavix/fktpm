<?php

namespace App\Models;

use Bavix\Helpers\JSON;
use Bavix\Helpers\Str;
use Conner\Tagging\Taggable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Album extends Model
{

    use Taggable;
    use Searchable;

    protected $table = 'albums';
    protected $route = 'album.view';

    /**
     * Получить имя индекса для модели.
     *
     * @return string
     */
    public function searchableAs()
    {
        return $this->table . '_index';
    }

    public function setPictureAttribute($picture, $toModel = true)
    {
        $model      = new Image();
        $model->src = $picture;
        $model->save();

        $this->id or $this->save();

        $model->doBackground();

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

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function images()
    {
        return $this->belongsToMany(Image::class, $this->table . '_images');
    }

    /**
     * @return string
     */
    public function url()
    {
        if (isset($this->main_page) && $this->main_page)
        {
            return route('home');
        }

        return route($this->route, [
            'id'    => $this->id,
            'title' => Str::friendlyUrl($this->title),
        ]);
    }

}
