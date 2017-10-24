<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\ModelUrl;

class Category extends Model
{

    use ModelUrl;

    protected $table = 'categories';
    protected $route = 'post.category';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

}
