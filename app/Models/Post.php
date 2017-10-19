<?php

namespace App\Models;

use Bavix\Helpers\Str;
use Illuminate\Database\Eloquent\Model;

class Post extends Page
{

    /**
     * @var string
     */
    protected $table    = 'posts';
    protected $route    = 'post.view';
    protected $routeTag = 'post.tag';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
