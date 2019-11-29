<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Post;

class PostService
{

    /**
     * @param string $title
     * @return Category
     */
    public function getCategory(string $title): Category
    {
        return Category::firstOrCreate(compact('title'));
    }

    /**
     * @param string $code
     * @return Post|null
     */
    public function byInstagramCode(string $code): ?Post
    {
        return Post::whereInstagramCode($code)->first();
    }

}
