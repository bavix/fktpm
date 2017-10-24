<?php

namespace App\Models;

class Tag extends \Spatie\Tags\Tag
{

    public function posts()
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }

    public function files()
    {
        return $this->morphedByMany(File::class, 'taggable');
    }

    public static function blocks()
    {
        return static::with('files.tags')
            ->orderBy('order_column', 'desc')
            ->where('is_block', 1)
            ->get();
    }

}
